<?php

namespace App\Services;

use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ClassService handles all class-related business logic.
 */
class ClassService
{
    /**
     * Get all classes with pagination.
     */
    public function getAllClasses(int $perPage = 15): LengthAwarePaginator
    {
        return ClassModel::with('section')->paginate($perPage);
    }

    /**
     * Get all classes without pagination.
     */
    public function getAllClassesNoPagination(): Collection
    {
        return ClassModel::with('section')->get();
    }

    /**
     * Get class by ID.
     */
    public function getClassById(int $id): ?ClassModel
    {
        return ClassModel::with('section')->find($id);
    }

    /**
     * Create a new class.
     */
    public function createClass(array $data): ClassModel
    {
        return ClassModel::create($data);
    }

    /**
     * Update an existing class.
     */
    public function updateClass(ClassModel $class, array $data): ClassModel
    {
        $class->update($data);

        return $class;
    }

    /**
     * Delete a class.
     */
    public function deleteClass(ClassModel $class): bool
    {
        return $class->delete();
    }

    /**
     * Count all classes.
     */
    public function countClasses(): int
    {
        return ClassModel::count();
    }
}
