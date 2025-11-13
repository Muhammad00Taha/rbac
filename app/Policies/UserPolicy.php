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
        return $user->can('users.view');
    }

    /**
     * Determine if the user can view a specific user.
     * Allowed for: Admin, Manager, or the user viewing themselves
     */
    public function view(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return $user->can('profiles.view');
        }

        return $user->can('users.view');
    }

    /**
     * Determine if the user can create users.
     * Allowed for: Admin, Manager
     */
    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    /**
     * Determine if the user can update a user.
     * Allowed for: same user, Admin, Manager (only standard Users)
     */
    public function update(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return $user->can('profiles.update');
        }

        // Admin can update anyone
        if ($user->hasRole('Admin')) {
            return $user->can('users.update');
        }

        // Manager can only update standard Users (not Admins or Managers)
        if ($user->hasRole('Manager')) {
            if ($model->hasRole(['Admin', 'Manager'])) {
                return false;
            }
            return $user->can('users.update');
        }

        return false;
    }

    /**
     * Determine if the user can delete a user.
     * Allowed for: Admin, Manager (only standard Users, excluding self)
     */
    public function delete(User $user, User $model): bool
    {
        // Cannot delete yourself
        if ($user->id === $model->id) {
            return false;
        }

        // Admin can delete anyone
        if ($user->hasRole('Admin')) {
            return $user->can('users.delete');
        }

        // Manager can only delete standard Users (not Admins or Managers)
        if ($user->hasRole('Manager')) {
            if ($model->hasRole(['Admin', 'Manager'])) {
                return false;
            }
            return $user->can('users.delete');
        }

        return false;
    }

    /**
     * Determine if the user can restore a user.
     * Allowed for: Admin only
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('users.delete');
    }

    /**
     * Determine if the user can permanently delete a user.
     * Allowed for: Admin only
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('users.delete');
    }
}
