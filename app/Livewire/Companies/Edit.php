<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use App\Services\CompanyService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Company $company;

    // Basic Information
    public $name = '';
    public $code = '';
    public $description = '';
    public $email = '';
    public $phone = '';
    public $website = '';

    // Address Information
    public $address = '';
    public $city = '';
    public $state = '';
    public $country = '';
    public $postal_code = '';

    // Business Information
    public $tax_number = '';
    public $registration_number = '';
    public $industry = '';
    public $founded_year = '';

    // Settings
    public $is_active = true;

    // File uploads
    public $logo;
    public $current_logo = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:companies,code,' . $this->company->id,
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'tax_number' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'industry' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'is_active' => 'boolean',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    protected $validationAttributes = [
        'name' => 'company name',
        'code' => 'company code',
        'email' => 'email address',
        'phone' => 'phone number',
        'website' => 'website URL',
        'postal_code' => 'postal code',
        'tax_number' => 'tax number',
        'registration_number' => 'registration number',
        'founded_year' => 'founded year',
    ];

    public function mount(Company $company)
    {
        $this->company = $company;

        // Populate form with existing data
        $this->name = $company->name;
        $this->code = $company->code;
        $this->description = $company->description;
        $this->email = $company->email;
        $this->phone = $company->phone;
        $this->website = $company->website;
        $this->address = $company->address;
        $this->city = $company->city;
        $this->state = $company->state;
        $this->country = $company->country;
        $this->postal_code = $company->postal_code;
        $this->tax_number = $company->tax_number;
        $this->registration_number = $company->registration_number;
        $this->industry = $company->industry;
        $this->founded_year = $company->founded_year;
        $this->is_active = $company->is_active;
        $this->current_logo = $company->logo;
    }

    public function save()
    {
        $this->validate();

        try {
            $companyData = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'email' => $this->email,
                'phone' => $this->phone,
                'website' => $this->website,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'postal_code' => $this->postal_code,
                'tax_number' => $this->tax_number,
                'registration_number' => $this->registration_number,
                'industry' => $this->industry,
                'founded_year' => $this->founded_year ?: null,
                'is_active' => $this->is_active,
            ];

            // Handle logo upload
            if ($this->logo) {
                $logoPath = $this->logo->store('company-logos', 'public');
                $companyData['logo'] = $logoPath;
            }

            $companyService = app(CompanyService::class);
            $updatedCompany = $companyService->updateCompany($this->company->id, $companyData);

            session()->flash('success', 'Company updated successfully.');

            return redirect()->route('companies.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating company: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.companies.edit');
    }
}
