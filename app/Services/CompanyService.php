<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use App\Models\Company;
use Illuminate\Support\Str;

class CompanyService extends BaseService
{
    public function __construct(CompanyRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create a new company with auto-generated code
     */
    public function createCompany(array $data): Company
    {
        // Generate unique company code if not provided
        if (empty($data['code'])) {
            $data['code'] = $this->generateUniqueCode($data['name']);
        }

        return $this->create($data);
    }

    /**
     * Generate unique company code
     */
    private function generateUniqueCode(string $name): string
    {
        $baseCode = Str::upper(Str::substr(Str::slug($name, ''), 0, 6));
        $code = $baseCode;
        $counter = 1;

        while ($this->repository->findByCode($code)) {
            $code = $baseCode . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }

        return $code;
    }

    /**
     * Get company by code
     */
    public function getByCode(string $code): ?Company
    {
        return $this->repository->findByCode($code);
    }

    /**
     * Get active companies
     */
    public function getActiveCompanies()
    {
        return $this->repository->getActive();
    }

    /**
     * Search companies
     */
    public function searchCompanies(string $term)
    {
        return $this->repository->search($term);
    }

    /**
     * Activate company
     */
    public function activate(int $id): Company
    {
        return $this->update($id, ['is_active' => true]);
    }

    /**
     * Deactivate company
     */
    public function deactivate(int $id): Company
    {
        return $this->update($id, ['is_active' => false]);
    }
}
