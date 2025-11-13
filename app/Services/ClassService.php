<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class ClassService
{
    /**
     * Get all classes.
     */
    public function getAllClasses(): Collection
    {
        // Placeholder: implement when Class model exists
        return collect([]);
    }

    /**
     * Get class by ID.
     */
    public function getClassById(int $id): ?object
    {
        // Placeholder: implement when Class model exists
        return null;
    }

    /**
     * Create a new class.
     */
    public function createClass(array $data): object
    {
        // Placeholder: implement when Class model exists
        // Should return created class instance
        return (object) $data;
    }

    /**
     * Update an existing class.
     */
    public function updateClass(int $id, array $data): object
    {
        // Placeholder: implement when Class model exists
        // Should return updated class instance
        return (object) $data;
    }

    /**
     * Delete a class.
     */
    public function deleteClass(int $id): bool
    {
        // Placeholder: implement when Class model exists
        return true;
    }

    /**
     * Count all classes.
     */
    public function countClasses(): int
    {
        // Placeholder: implement when Class model exists
        return 0;
    }
}
