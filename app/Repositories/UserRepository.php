<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Find user by employee ID
     */
    public function findByEmployeeId(string $employeeId): ?User
    {
        return $this->model->where('employee_id', $employeeId)->first();
    }

    /**
     * Get users by company
     */
    public function getByCompany(int $companyId): Collection
    {
        return $this->model->where('company_id', $companyId)->get();
    }

    /**
     * Get users by department
     */
    public function getByDepartment(int $departmentId): Collection
    {
        return $this->model->where('department_id', $departmentId)->get();
    }

    /**
     * Get active users
     */
    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    /**
     * Get users by employment status
     */
    public function getByEmploymentStatus(string $status): Collection
    {
        return $this->model->byEmploymentStatus($status)->get();
    }

    /**
     * Search users by name, email, or employee ID
     */
    public function search(string $term): Collection
    {
        return $this->model
            ->where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('employee_id', 'like', "%{$term}%")
            ->orWhere('first_name', 'like', "%{$term}%")
            ->orWhere('last_name', 'like', "%{$term}%")
            ->get();
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(int $userId): void
    {
        $this->model->where('id', $userId)->update([
            'last_login_at' => now()
        ]);
    }
}
