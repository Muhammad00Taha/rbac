<?php

namespace App\Services;

use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * SectionService handles all section-related business logic.
 */
class SectionService
{
    /**
     * Get all sections with pagination.
     */
    public function getAllSections(int $perPage = 15): LengthAwarePaginator
    {
        return Section::paginate($perPage);
    }

    /**
     * Get all sections without pagination.
     */
    public function getAllSectionsNoPagination(): Collection
    {
        return Section::all();
    }

    /**
     * Get section by ID.
     */
    public function getSectionById(int $id): ?Section
    {
        return Section::find($id);
    }

    /**
     * Create a new section.
     */
    public function createSection(array $data): Section
    {
        return Section::create($data);
    }

    /**
     * Update an existing section.
     */
    public function updateSection(Section $section, array $data): Section
    {
        $section->update($data);

        return $section;
    }

    /**
     * Delete a section.
     */
    public function deleteSection(Section $section): bool
    {
        return $section->delete();
    }

    /**
     * Count all sections.
     */
    public function countSections(): int
    {
        return Section::count();
    }
}
