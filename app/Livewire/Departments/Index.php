<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use App\Models\Company;
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
    public $status_filter = '';

    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'company_filter' => ['except' => ''],
        'status_filter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCompanyFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
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

    public function deleteDepartment($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        // Check if department has users
        if ($department->users()->count() > 0) {
            session()->flash('error', 'Cannot delete department with existing employees. Please transfer or remove employees first.');
            return;
        }

        $department->delete();
        session()->flash('success', 'Department deleted successfully.');
    }

    public function toggleDepartmentStatus($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $department->update(['is_active' => !$department->is_active]);

        session()->flash('success', 'Department status updated successfully.');
    }

    public function render()
    {
        $departments = Department::query()
            ->with(['company', 'parent'])
            ->withCount('users')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->company_filter, function ($query) {
                $query->where('company_id', $this->company_filter);
            })
            ->when($this->status_filter, function ($query) {
                if ($this->status_filter === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        // Get companies for filter
        $companies = Company::where('is_active', true)->get();

        return view('livewire.departments.index', [
            'departments' => $departments,
            'companies' => $companies,
        ]);
    }
}
