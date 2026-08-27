<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 POSTS (THIS WAS MISSING)
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/restore', [PostController::class, 'restore'])
        ->name('posts.restore');
});

Route::get('/my-posts', [PostController::class, 'myPosts'])
    ->middleware('auth')
    ->name('my-posts');

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/role', [UserController::class, 'assignRole'])->name('users.assignRole');

    // 🔥 PERMISSION MANAGEMENT
    Route::resource('permissions', PermissionController::class)
        ->except(['show', 'edit', 'update', 'create']);
    Route::post('/permissions/{permission}/assign-role', [PermissionController::class, 'assignToRole'])
        ->name('permissions.assign-role');
});

require __DIR__ . '/auth.php';
