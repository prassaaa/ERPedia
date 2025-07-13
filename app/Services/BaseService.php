<?php

namespace App\Services;

use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     */
    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Get paginated records
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    /**
     * Find record by ID
     */
    public function findById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * Find record by ID or fail
     */
    public function findByIdOrFail(int $id): Model
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Create new record
     */
    public function create(array $data): Model
    {
        try {
            DB::beginTransaction();
            
            $record = $this->repository->create($data);
            
            DB::commit();
            
            Log::info(class_basename($this) . ' created', ['id' => $record->id]);
            
            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating ' . class_basename($this), [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Update record
     */
    public function update(int $id, array $data): Model
    {
        try {
            DB::beginTransaction();
            
            $record = $this->repository->update($id, $data);
            
            DB::commit();
            
            Log::info(class_basename($this) . ' updated', ['id' => $id]);
            
            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating ' . class_basename($this), [
                'error' => $e->getMessage(),
                'id' => $id,
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();
            
            $result = $this->repository->delete($id);
            
            DB::commit();
            
            Log::info(class_basename($this) . ' deleted', ['id' => $id]);
            
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting ' . class_basename($this), [
                'error' => $e->getMessage(),
                'id' => $id
            ]);
            throw $e;
        }
    }

    /**
     * Find records by criteria
     */
    public function findBy(array $criteria): Collection
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Find single record by criteria
     */
    public function findOneBy(array $criteria): ?Model
    {
        return $this->repository->findOneBy($criteria);
    }
}
