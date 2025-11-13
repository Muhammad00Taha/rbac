<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
// the RoleMiddleware prevents them from touching role/permission routes.
Route::prefix('users')->middleware(['auth', 'role'])->group(function () {
    // Example routes using closures so route registration is safe without
    // requiring additional controllers right now.
    Route::get('/', fn () => 'Users index (manager/admin)')->name('users.index');
    Route::get('/create', fn () => 'Users create (manager/admin)')->name('users.create');
    Route::post('/', fn () => 'Users store (manager/admin)')->name('users.store');
    Route::get('/{id}', fn ($id) => "Users show {$id} (manager/admin)")->name('users.show');
    Route::put('/{id}', fn ($id) => "Users update {$id} (manager/admin)")->name('users.update');
    Route::delete('/{id}', fn ($id) => "Users delete {$id} (manager/admin)")->name('users.destroy');
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
