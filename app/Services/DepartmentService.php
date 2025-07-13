<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DepartmentService extends BaseService
{
    protected $model = Department::class;

    /**
     * Create a new department.
     */
    public function createDepartment(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            $department = Department::create($data);
            
            // Log activity
            activity()
                ->performedOn($department)
                ->causedBy(auth()->user())
                ->log('Department created');
            
            return $department->load(['company', 'parent', 'manager']);
        });
    }

    /**
     * Update an existing department.
     */
    public function updateDepartment(int $id, array $data): Department
    {
        return DB::transaction(function () use ($id, $data) {
            $department = Department::findOrFail($id);
            $originalData = $department->toArray();
            
            $department->update($data);
            
            // Log activity
            activity()
                ->performedOn($department)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old' => $originalData,
                    'new' => $department->fresh()->toArray()
                ])
                ->log('Department updated');
            
            return $department->load(['company', 'parent', 'manager']);
        });
    }

    /**
     * Delete a department.
     */
    public function deleteDepartment(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $department = Department::findOrFail($id);
            
            // Check if department has users
            if ($department->users()->count() > 0) {
                throw new \Exception('Cannot delete department with existing employees.');
            }
            
            // Check if department has child departments
            if ($department->children()->count() > 0) {
                throw new \Exception('Cannot delete department with child departments.');
            }
            
            // Log activity before deletion
            activity()
                ->performedOn($department)
                ->causedBy(auth()->user())
                ->log('Department deleted');
            
            return $department->delete();
        });
    }

    /**
     * Get departments by company.
     */
    public function getDepartmentsByCompany(int $companyId): Collection
    {
        return Department::where('company_id', $companyId)
            ->where('is_active', true)
            ->with(['parent', 'manager'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get department hierarchy for a company.
     */
    public function getDepartmentHierarchy(int $companyId): Collection
    {
        return Department::where('company_id', $companyId)
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->with('children.children'); // Load up to 3 levels
            }])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all descendants of a department.
     */
    public function getAllDescendants(int $departmentId): array
    {
        $descendants = [];
        $this->collectDescendants($departmentId, $descendants);
        return $descendants;
    }

    /**
     * Recursively collect all descendant department IDs.
     */
    private function collectDescendants(int $departmentId, array &$descendants): void
    {
        $children = Department::where('parent_id', $departmentId)->pluck('id');
        
        foreach ($children as $childId) {
            $descendants[] = $childId;
            $this->collectDescendants($childId, $descendants);
        }
    }

    /**
     * Check if moving a department would create a circular reference.
     */
    public function wouldCreateCircularReference(int $departmentId, int $newParentId): bool
    {
        $descendants = $this->getAllDescendants($departmentId);
        return in_array($newParentId, $descendants);
    }

    /**
     * Get department statistics.
     */
    public function getDepartmentStats(int $departmentId): array
    {
        $department = Department::with(['users', 'children'])->findOrFail($departmentId);
        
        return [
            'total_employees' => $department->users()->count(),
            'active_employees' => $department->users()->where('is_active', true)->count(),
            'child_departments' => $department->children()->count(),
            'active_children' => $department->children()->where('is_active', true)->count(),
        ];
    }

    /**
     * Get departments with employee counts.
     */
    public function getDepartmentsWithCounts(): Collection
    {
        return Department::withCount(['users', 'children'])
            ->with(['company', 'parent', 'manager'])
            ->orderBy('name')
            ->get();
    }
}
