<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create a new user with auto-generated employee ID
     */
    public function createUser(array $data): User
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Generate unique employee ID if not provided
        if (empty($data['employee_id']) && !empty($data['company_id'])) {
            $data['employee_id'] = $this->generateUniqueEmployeeId($data['company_id']);
        }

        return $this->create($data);
    }

    /**
     * Update user with password hashing
     */
    public function updateUser(int $id, array $data): User
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove password from data if empty to avoid overwriting
            unset($data['password']);
        }

        return $this->update($id, $data);
    }

    /**
     * Generate unique employee ID
     */
    private function generateUniqueEmployeeId(int $companyId): string
    {
        $prefix = 'EMP';
        $year = date('Y');
        $baseId = $prefix . $year;
        
        // Find the last employee ID for this company
        $lastUser = User::where('company_id', $companyId)
            ->where('employee_id', 'like', $baseId . '%')
            ->orderBy('employee_id', 'desc')
            ->first();

        if ($lastUser) {
            $lastNumber = (int) substr($lastUser->employee_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $baseId . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get user by email
     */
    public function getByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * Get user by employee ID
     */
    public function getByEmployeeId(string $employeeId): ?User
    {
        return $this->repository->findByEmployeeId($employeeId);
    }

    /**
     * Get users by company
     */
    public function getUsersByCompany(int $companyId)
    {
        return $this->repository->getByCompany($companyId);
    }

    /**
     * Get users by department
     */
    public function getUsersByDepartment(int $departmentId)
    {
        return $this->repository->getByDepartment($departmentId);
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->repository->getActive();
    }

    /**
     * Search users
     */
    public function searchUsers(string $term)
    {
        return $this->repository->search($term);
    }

    /**
     * Activate user
     */
    public function activate(int $id): User
    {
        return $this->update($id, ['is_active' => true, 'employment_status' => 'active']);
    }

    /**
     * Deactivate user
     */
    public function deactivate(int $id): User
    {
        return $this->update($id, ['is_active' => false, 'employment_status' => 'inactive']);
    }

    /**
     * Update last login
     */
    public function updateLastLogin(int $userId): void
    {
        $this->repository->updateLastLogin($userId);
    }

    /**
     * Assign role to user
     */
    public function assignRole(int $userId, string $role): User
    {
        $user = $this->findByIdOrFail($userId);
        $user->assignRole($role);
        return $user;
    }

    /**
     * Remove role from user
     */
    public function removeRole(int $userId, string $role): User
    {
        $user = $this->findByIdOrFail($userId);
        $user->removeRole($role);
        return $user;
    }
}
