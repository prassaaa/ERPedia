<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;

class Show extends Component
{
    public Company $company;

    public function mount(Company $company)
    {
        $this->company = $company->load(['users', 'departments']);
    }

    public function toggleCompanyStatus()
    {
        $this->company->update([
            'is_active' => !$this->company->is_active
        ]);

        $this->company->refresh();
        session()->flash('success', 'Company status updated successfully.');
    }

    public function render()
    {
        // Get company statistics
        $stats = [
            'total_employees' => $this->company->users()->count(),
            'active_employees' => $this->company->users()->where('is_active', true)->count(),
            'total_departments' => $this->company->departments()->count(),
            'active_departments' => $this->company->departments()->where('is_active', true)->count(),
        ];

        // Get recent employees
        $recentEmployees = $this->company->users()
            ->latest()
            ->take(5)
            ->get();

        // Get departments
        $departments = $this->company->departments()
            ->withCount('users')
            ->get();

        return view('livewire.companies.show', [
            'stats' => $stats,
            'recentEmployees' => $recentEmployees,
            'departments' => $departments,
        ]);
    }
}
