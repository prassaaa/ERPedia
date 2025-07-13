<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use App\Models\Company;
use App\Services\DepartmentService;
use Livewire\Component;

class Edit extends Component
{
    public Department $department;

    // Basic Information
    public $company_id = '';
    public $parent_id = '';
    public $name = '';
    public $code = '';
    public $description = '';

    // Contact Information
    public $email = '';
    public $phone = '';
    public $location = '';

    // Manager Information
    public $manager_id = '';

    // Settings
    public $is_active = true;

    protected function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'parent_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:departments,code,' . $this->department->id,
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'company_id' => 'company',
        'parent_id' => 'parent department',
        'name' => 'department name',
        'code' => 'department code',
        'email' => 'email address',
        'phone' => 'phone number',
        'manager_id' => 'manager',
    ];

    public function mount(Department $department)
    {
        $this->department = $department;

        // Populate form with existing data
        $this->company_id = $department->company_id;
        $this->parent_id = $department->parent_id;
        $this->name = $department->name;
        $this->code = $department->code;
        $this->description = $department->description;
        $this->email = $department->email;
        $this->phone = $department->phone;
        $this->location = $department->location;
        $this->manager_id = $department->manager_id;
        $this->is_active = $department->is_active;
    }

    public function updatedCompanyId()
    {
        // Reset parent department and manager when company changes
        $this->parent_id = '';
        $this->manager_id = '';
    }

    public function save()
    {
        // Validate that parent is not the same as current department or its children
        if ($this->parent_id == $this->department->id) {
            $this->addError('parent_id', 'A department cannot be its own parent.');
            return;
        }

        // Check if the selected parent would create a circular reference
        if ($this->parent_id && $this->wouldCreateCircularReference($this->parent_id)) {
            $this->addError('parent_id', 'This would create a circular reference in the department hierarchy.');
            return;
        }

        $this->validate();

        try {
            $departmentData = [
                'company_id' => $this->company_id,
                'parent_id' => $this->parent_id ?: null,
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
                'manager_id' => $this->manager_id ?: null,
                'is_active' => $this->is_active,
            ];

            $departmentService = app(DepartmentService::class);
            $updatedDepartment = $departmentService->updateDepartment($this->department->id, $departmentData);

            session()->flash('success', 'Department updated successfully.');

            return redirect()->route('departments.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating department: ' . $e->getMessage());
        }
    }

    private function wouldCreateCircularReference($parentId)
    {
        // Get all descendants of current department
        $descendants = $this->getAllDescendants($this->department->id);

        // Check if the proposed parent is among the descendants
        return in_array($parentId, $descendants);
    }

    private function getAllDescendants($departmentId, $descendants = [])
    {
        $children = Department::where('parent_id', $departmentId)->pluck('id')->toArray();

        foreach ($children as $childId) {
            $descendants[] = $childId;
            $descendants = $this->getAllDescendants($childId, $descendants);
        }

        return $descendants;
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();

        $parentDepartments = collect();
        if ($this->company_id) {
            $parentDepartments = Department::where('company_id', $this->company_id)
                ->where('is_active', true)
                ->where('id', '!=', $this->department->id) // Exclude current department
                ->get();
        }

        $managers = collect();
        if ($this->company_id) {
            $managers = \App\Models\User::where('company_id', $this->company_id)
                ->where('is_active', true)
                ->get();
        }

        return view('livewire.departments.edit', [
            'companies' => $companies,
            'parentDepartments' => $parentDepartments,
            'managers' => $managers,
        ]);
    }
}
