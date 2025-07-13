<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    /**
     * Find company by code
     */
    public function findByCode(string $code): ?Company
    {
        return $this->model->where('code', $code)->first();
    }

    /**
     * Get active companies
     */
    public function getActive()
    {
        return $this->model->active()->get();
    }

    /**
     * Search companies by name or code
     */
    public function search(string $term)
    {
        return $this->model
            ->where('name', 'like', "%{$term}%")
            ->orWhere('code', 'like', "%{$term}%")
            ->get();
    }
}
