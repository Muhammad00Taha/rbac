<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;

class SectionPolicy
{
    /**
     * Determine if the user can view any sections.
     * Allowed for: Admin, Manager
     */
    public function viewAny(User $user): bool
    {
        return $user->can('sections.view');
    }

    /**
     * Determine if the user can view a specific section.
     * Allowed for: Admin, Manager
     */
    public function view(User $user, Section $section): bool
    {
        return $user->can('sections.view');
    }

    /**
     * Determine if the user can create sections.
     * Allowed for: Admin, Manager
     */
    public function create(User $user): bool
    {
        return $user->can('sections.create');
    }

    /**
     * Determine if the user can update a section.
     * Allowed for: Admin, Manager
     */
    public function update(User $user, Section $section): bool
    {
        return $user->can('sections.update');
    }

    /**
     * Determine if the user can delete a section.
     * Allowed for: Admin, Manager
     */
    public function delete(User $user, Section $section): bool
    {
        return $user->can('sections.delete');
    }
}

