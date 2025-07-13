<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $company_filter = '';

    #[Url]
    public $department_filter = '';

    #[Url]
    public $status_filter = '';

    #[Url]
    public $employment_type_filter = '';

    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'company_filter' => ['except' => ''],
        'department_filter' => ['except' => ''],
        'status_filter' => ['except' => ''],
        'employment_type_filter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCompanyFilter()
    {
        $this->resetPage();
    }

    public function updatingDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingEmploymentTypeFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
        $this->resetPage();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent deleting current user
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
    }

    public function toggleUserStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_active' => !$user->is_active,
            'employment_status' => $user->is_active ? 'inactive' : 'active'
        ]);

        session()->flash('success', 'User status updated successfully.');
    }

    public function render()
    {
        $users = User::query()
            ->with(['company', 'department'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('employee_id', 'like', '%' . $this->search . '%')
                      ->orWhere('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->company_filter, function ($query) {
                $query->where('company_id', $this->company_filter);
            })
            ->when($this->department_filter, function ($query) {
                $query->where('department_id', $this->department_filter);
            })
            ->when($this->status_filter, function ($query) {
                $query->where('employment_status', $this->status_filter);
            })
            ->when($this->employment_type_filter, function ($query) {
                $query->where('employment_type', $this->employment_type_filter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $companies = Company::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('livewire.users.index', [
            'users' => $users,
            'companies' => $companies,
            'departments' => $departments,
        ]);
    }
}
