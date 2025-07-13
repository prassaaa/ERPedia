<?php

namespace App\Livewire\Companies;

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
    public $status_filter = '';

    #[Url]
    public $country_filter = '';

    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status_filter' => ['except' => ''],
        'country_filter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCountryFilter()
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

    public function deleteCompany($companyId)
    {
        $company = Company::findOrFail($companyId);

        // Check if company has users
        if ($company->users()->count() > 0) {
            session()->flash('error', 'Cannot delete company with existing employees. Please transfer or remove employees first.');
            return;
        }

        $company->delete();
        session()->flash('success', 'Company deleted successfully.');
    }

    public function toggleCompanyStatus($companyId)
    {
        $company = Company::findOrFail($companyId);
        $company->update(['is_active' => !$company->is_active]);

        session()->flash('success', 'Company status updated successfully.');
    }

    public function render()
    {
        $companies = Company::query()
            ->withCount(['users', 'departments'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('website', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status_filter, function ($query) {
                if ($this->status_filter === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            })
            ->when($this->country_filter, function ($query) {
                $query->where('country', $this->country_filter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        // Get unique countries for filter
        $countries = Company::whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->pluck('country')
            ->sort();

        return view('livewire.companies.index', [
            'companies' => $companies,
            'countries' => $countries,
        ]);
    }
}
