<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

/**
 * UserService handles all user-related business logic.
 * This service encapsulates creation, updating, deletion, and role assignment.
 */
class UserService
{
    /**
     * Get all users with pagination.
     */
    public function getAllUsers(int $perPage = 15): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    /**
     * Get a single user by ID.
     */
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Get users by role.
     */
    public function getUsersByRole(string $roleName): \Illuminate\Database\Eloquent\Collection
    {
        return User::role($roleName)->get();
    }

    /**
     * Create a new user.
     *
     * @param array $data User attributes (name, email, password, etc.)
     * @return User
     */
    public function createUser(array $data): User
    {
        $user = User::create($data);

        // If a role is provided in the data, assign it
        if (isset($data['role']) && $data['role']) {
            $this->assignRole($user, $data['role']);
        }

        return $user;
    }

    /**
     * Update an existing user.
     *
     * @param User $user The user to update
     * @param array $data New attributes
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);

        // If a role is provided, update it
        if (isset($data['role']) && $data['role']) {
            $this->assignRole($user, $data['role']);
        }

        return $user;
    }

    /**
     * Delete a user.
     *
     * @param User $user The user to delete
     * @return bool
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Assign a role to a user.
     *
     * @param User $user The user
     * @param string $roleName The role name
     * @return void
     */
    public function assignRole(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            // Remove previous roles and assign the new one
            $user->syncRoles($role);
        }
    }

    /**
     * Check if a user has a specific role.
     *
     * @param User $user The user
     * @param string $roleName The role name
     * @return bool
     */
    public function hasRole(User $user, string $roleName): bool
    {
        return $user->hasRole($roleName);
    }

    /**
     * Get all available roles.
     */
    public function getAllRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    /**
     * Count total users.
     */
    public function countUsers(): int
    {
        return User::count();
    }
}
