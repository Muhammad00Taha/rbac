<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('users', UserController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('classes', ClassController::class);
    
    // AJAX endpoint for Select2 section dropdown
    Route::get('/api/sections/select2', [ClassController::class, 'getSections'])->name('api.sections.select2');
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
