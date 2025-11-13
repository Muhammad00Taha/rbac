<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes for regular users (can view/edit own profile). The `role` middleware
// enforces that Users may only access profile routes while Admin/Manager are
// permitted according to their privileges.
Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Manager routes: example user management area. Managers can CRUD users but
// the RoleMiddleware and UserPolicy prevent them from touching role/permission routes.
Route::prefix('users')->middleware(['auth', 'role'])->group(function () {
    // Example routes using closures so route registration is safe without
    // requiring additional controllers right now.
    Route::get('/', function () {
        Gate::authorize('viewAny', User::class);
        return 'Users index (manager/admin)';
    })->name('users.index');

    Route::get('/create', function () {
        Gate::authorize('create', User::class);
        return 'Users create (admin only)';
    })->name('users.create');

    Route::post('/', function () {
        Gate::authorize('create', User::class);
        return 'Users store (admin only)';
    })->name('users.store');

    Route::get('/{id}', function ($id) {
        $user = User::findOrFail($id);
        Gate::authorize('view', $user);
        return "Users show {$id} (manager/admin)";
    })->name('users.show');

    Route::put('/{id}', function ($id) {
        $user = User::findOrFail($id);
        Gate::authorize('update', $user);
        return "Users update {$id} (manager/admin)";
    })->name('users.update');

    Route::delete('/{id}', function ($id) {
        $user = User::findOrFail($id);
        Gate::authorize('delete', $user);
        return "Users delete {$id} (admin only)";
    })->name('users.destroy');
});

// Admin-only routes: full access area. RoleMiddleware allows Admins through.
Route::prefix('admin')->middleware(['auth', 'role'])->group(function () {
    Route::get('/', fn () => 'Admin dashboard (admin only)')->name('admin.dashboard');
    // Example role/permission management route names include 'role' and
    // 'permission' so RoleMiddleware will protect them from Managers.
    Route::get('/roles', fn () => 'Role management (admin only)')->name('roles.index');
    Route::post('/roles', fn () => 'Create role (admin only)')->name('roles.store');
});

require __DIR__.'/auth.php';
