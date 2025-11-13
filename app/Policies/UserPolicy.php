<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any users.
     * Allowed for: Admin, Manager
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Determine if the user can view a specific user.
     * Allowed for: Admin, Manager, or the user viewing themselves
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']) || $user->id === $model->id;
    }

    /**
     * Determine if the user can create users.
     * Allowed for: Admin only
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine if the user can update a user.
     * Allowed for: same user or Admin
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('Admin');
    }

    /**
     * Determine if the user can delete a user.
     * Allowed for: Admin only
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine if the user can restore a user.
     * Allowed for: Admin only
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine if the user can permanently delete a user.
     * Allowed for: Admin only
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('Admin');
    }
}
