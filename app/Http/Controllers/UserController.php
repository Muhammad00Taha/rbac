<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request): View|JsonResponse
    {
        // Check authorization using UserPolicy
        Gate::authorize('viewAny', User::class);

        if ($request->ajax()) {
            $query = User::query()->with('roles')->select('users.*');

            return DataTables::eloquent($query)
                ->addColumn('role', static function (User $user): string {
                    return view('users.partials.role', [
                        'roles' => $user->getRoleNames(),
                    ])->render();
                })
                ->addColumn('actions', static function (User $user): string {
                    return view('users.partials.actions', compact('user'))->render();
                })
                ->editColumn('name', static function (User $user): string {
                    return view('users.partials.name', compact('user'))->render();
                })
                ->filterColumn('role', static function ($query, string $keyword): void {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                    $query->whereHas('roles', static function ($roleQuery) use ($keyword): void {
                        $roleQuery->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->rawColumns(['name', 'role', 'actions'])
                ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        // Check authorization using UserPolicy
        Gate::authorize('create', User::class);

        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Check authorization using UserPolicy
        Gate::authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
        ]);

        if (! $request->user()->can('users.assignRoles')) {
            unset($validated['role']);
        }

        // Use UserService to create the user
        $user = $this->userService->createUser($validated);

        return redirect()->route('users.show', $user)->with('status', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        // Check authorization using UserPolicy
        Gate::authorize('view', $user);

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        // Check authorization using UserPolicy
        Gate::authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Check authorization using UserPolicy
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['nullable', 'string', 'exists:roles,name'],
        ]);

        if (! $request->user()->can('users.assignRoles')) {
            unset($validated['role']);
        }

        // Use UserService to update the user
        $this->userService->updateUser($user, $validated);

        return redirect()->route('users.show', $user)->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Check authorization using UserPolicy
        Gate::authorize('delete', $user);

        // Use UserService to delete the user
        $this->userService->deleteUser($user);

        return redirect()->route('users.index')->with('status', 'User deleted successfully.');
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore(int $userId)
    {
        $user = User::onlyTrashed()->findOrFail($userId);

        // Check authorization using UserPolicy
        Gate::authorize('restore', $user);

        $user->restore();

        return redirect()->route('users.show', $user)->with('status', 'User restored successfully.');
    }

    /**
     * Permanently delete a user.
     */
    public function forceDelete(int $userId)
    {
        $user = User::onlyTrashed()->findOrFail($userId);

        // Check authorization using UserPolicy
        Gate::authorize('forceDelete', $user);

        $user->forceDelete();

        return redirect()->route('users.index')->with('status', 'User permanently deleted.');
    }
}
