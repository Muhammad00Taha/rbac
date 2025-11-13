<?php

namespace App\Policies;

use App\Models\User;

class ProfilePolicy
{
    /**
     * Determine if the user can view their own profile.
     * Allowed for: any authenticated user (viewing their own) or Admin
     */
    public function view(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return $user->can('profiles.view');
        }

        return $user->can('users.view');
    }

    /**
     * Determine if the user can update their own profile.
     * Allowed for: the user updating their own or Admin
     */
    public function update(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return $user->can('profiles.update');
        }

        return $user->can('users.update');
    }

    /**
     * Determine if the user can delete their own profile.
     * Allowed for: the user deleting their own or Admin
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return $user->can('profiles.delete');
        }

        return $user->can('users.delete');
    }
}
