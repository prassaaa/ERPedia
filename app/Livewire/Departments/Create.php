<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use App\Models\Company;
use App\Services\DepartmentService;
use Livewire\Component;

class Create extends Component
{
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
            'code' => 'nullable|string|max:20|unique:departments,code',
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

    public function updatedCompanyId()
    {
        // Reset parent department when company changes
        $this->parent_id = '';
        $this->manager_id = '';
    }

    public function save()
    {
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
            $department = $departmentService->createDepartment($departmentData);

            session()->flash('success', 'Department created successfully.');

            return redirect()->route('departments.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating department: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();

        $parentDepartments = collect();
        if ($this->company_id) {
            $parentDepartments = Department::where('company_id', $this->company_id)
                ->where('is_active', true)
                ->get();
        }

        $managers = collect();
        if ($this->company_id) {
            $managers = \App\Models\User::where('company_id', $this->company_id)
                ->where('is_active', true)
                ->get();
        }

        return view('livewire.departments.create', [
            'companies' => $companies,
            'parentDepartments' => $parentDepartments,
            'managers' => $managers,
        ]);
    }
}
