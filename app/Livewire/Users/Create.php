<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Services\UserService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    use WithFileUploads;

    // User basic info
    public $company_id = '';
    public $department_id = '';
    public $employee_id = '';
    public $name = '';
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // Contact info
    public $phone = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $country = '';
    public $postal_code = '';

    // Employment info
    public $hire_date = '';
    public $employment_status = 'active';
    public $employment_type = 'full_time';
    public $salary = '';

    // Personal info
    public $birth_date = '';
    public $gender = '';

    // Role
    public $role = 'employee';

    // File upload
    public $avatar;

    protected function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id' => 'nullable|unique:users,employee_id',
            'name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'hire_date' => 'nullable|date',
            'employment_status' => 'required|in:active,inactive,terminated,resigned',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'salary' => 'nullable|numeric|min:0',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    protected $validationAttributes = [
        'company_id' => 'company',
        'department_id' => 'department',
        'employee_id' => 'employee ID',
        'first_name' => 'first name',
        'last_name' => 'last name',
        'password_confirmation' => 'password confirmation',
        'hire_date' => 'hire date',
        'employment_status' => 'employment status',
        'employment_type' => 'employment type',
        'birth_date' => 'birth date',
        'postal_code' => 'postal code',
    ];

    public function mount()
    {
        // Set default company if user has one
        if (auth()->user()->company_id) {
            $this->company_id = auth()->user()->company_id;
        }

        // Set default hire date to today
        $this->hire_date = now()->format('Y-m-d');
    }

    public function updatedCompanyId()
    {
        // Reset department when company changes
        $this->department_id = '';
    }

    public function save()
    {
        $this->validate();

        try {
            $userData = [
                'company_id' => $this->company_id,
                'department_id' => $this->department_id ?: null,
                'employee_id' => $this->employee_id,
                'name' => $this->name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => $this->password,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'postal_code' => $this->postal_code,
                'hire_date' => $this->hire_date,
                'employment_status' => $this->employment_status,
                'employment_type' => $this->employment_type,
                'salary' => $this->salary ?: null,
                'birth_date' => $this->birth_date ?: null,
                'gender' => $this->gender ?: null,
                'is_active' => $this->employment_status === 'active',
            ];

            // Handle avatar upload
            if ($this->avatar) {
                $avatarPath = $this->avatar->store('avatars', 'public');
                $userData['avatar'] = $avatarPath;
            }

            $userService = app(UserService::class);
            $user = $userService->createUser($userData);

            // Assign role
            $user->assignRole($this->role);

            session()->flash('success', 'Employee created successfully.');

            return redirect()->route('users.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating employee: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $companies = Company::where('is_active', true)->get();
        $departments = Department::where('is_active', true)
            ->when($this->company_id, function ($query) {
                $query->where('company_id', $this->company_id);
            })
            ->get();
        $roles = Role::all();

        return view('livewire.users.create', [
            'companies' => $companies,
            'departments' => $departments,
            'roles' => $roles,
        ]);
    }
}
