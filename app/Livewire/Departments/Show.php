<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Livewire\Component;

class Show extends Component
{
    public Department $department;

    public function mount(Department $department)
    {
        $this->department = $department->load(['company', 'parent', 'manager', 'users', 'children']);
    }

    public function toggleDepartmentStatus()
    {
        $this->department->update([
            'is_active' => !$this->department->is_active
        ]);

        $this->department->refresh();
        session()->flash('success', 'Department status updated successfully.');
    }

    public function render()
    {
        // Get department statistics
        $stats = [
            'total_employees' => $this->department->users()->count(),
            'active_employees' => $this->department->users()->where('is_active', true)->count(),
            'child_departments' => $this->department->children()->count(),
            'active_children' => $this->department->children()->where('is_active', true)->count(),
        ];

        // Get recent employees
        $recentEmployees = $this->department->users()
            ->latest()
            ->take(5)
            ->get();

        // Get child departments
        $childDepartments = $this->department->children()
            ->withCount('users')
            ->get();

        // Get department hierarchy (breadcrumb)
        $hierarchy = $this->getDepartmentHierarchy($this->department);

        return view('livewire.departments.show', [
            'stats' => $stats,
            'recentEmployees' => $recentEmployees,
            'childDepartments' => $childDepartments,
            'hierarchy' => $hierarchy,
        ]);
    }

    private function getDepartmentHierarchy($department, $hierarchy = [])
    {
        array_unshift($hierarchy, $department);

        if ($department->parent) {
            return $this->getDepartmentHierarchy($department->parent, $hierarchy);
        }

        return $hierarchy;
    }
}
