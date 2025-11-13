<?php

namespace App\Policies;

use App\Models\ClassModel;
use App\Models\User;

class ClassPolicy
{
    /**
     * Determine if the user can view any classes.
     * Allowed for: Admin, Manager
     */
    public function viewAny(User $user): bool
    {
        return $user->can('classes.view');
    }

    /**
     * Determine if the user can view a specific class.
     * Allowed for: Admin, Manager
     */
    public function view(User $user, ClassModel $class): bool
    {
        return $user->can('classes.view');
    }

    /**
     * Determine if the user can create classes.
     * Allowed for: Admin, Manager
     */
    public function create(User $user): bool
    {
        return $user->can('classes.create');
    }

    /**
     * Determine if the user can update a class.
     * Allowed for: Admin, Manager
     */
    public function update(User $user, ClassModel $class): bool
    {
        return $user->can('classes.update');
    }

    /**
     * Determine if the user can delete a class.
     * Allowed for: Admin, Manager
     */
    public function delete(User $user, ClassModel $class): bool
    {
        return $user->can('classes.delete');
    }
}

