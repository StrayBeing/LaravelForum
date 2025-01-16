<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Middleware\RoleMiddleware;
use App\Http\Controllers\PostController;
// Home Route 
use App\Http\Controllers\ModeratorDashboardController;
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route for All Roles
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Admin Routesa
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/create-user', [AdminDashboardController::class, 'createUser'])->name('createUser');
    Route::post('/ban-user/{id}', [AdminDashboardController::class, 'banUser'])->name('banUser');
    Route::post('/unban-user/{id}', [AdminDashboardController::class, 'unbanUser'])->name('unbanUser');
    Route::delete('/delete-user/{id}', [AdminDashboardController::class, 'deleteUser'])->name('deleteUser'); 
    Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('editUser');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('updateUser');
    Route::get('/create-user', [AdminDashboardController::class, 'createUserForm'])->name('createUserForm');
    Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('storeUser');
    
});

// Forum and Profile Routes (Accessible to all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [PostController::class, 'create'])->name('forum.create');
    Route::post('/forum/store', [PostController::class, 'store'])->name('forum.store');
    Route::get('/forum/{post}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/{post}/vote', [ForumController::class, 'vote'])->name('forum.vote');
    Route::post('/forum/{post}/comment', [ForumController::class, 'addComment'])->name('forum.comment');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/post/{postId}/vote', [VoteController::class, 'vote'])->name('vote');
     // Edycja postu
     Route::get('/forum/{post}/edit', [PostController::class, 'edit'])->name('forum.edit');
     Route::put('/forum/{post}', [PostController::class, 'update'])->name('forum.update');
 
     // Usuwanie postu
     Route::delete('/forum/{post}', [PostController::class, 'destroy'])->name('forum.destroy');
});

// Moderator Routes
Route::middleware(['auth', 'role:moderator'])->prefix('moderator')->name('moderator.')->group(function () {
    Route::get('/dashboard', [ModeratorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/{user}/edit', [ModeratorDashboardController::class, 'editUser'])->name('editUser');
    Route::put('/users/{user}', [ModeratorDashboardController::class, 'updateUser'])->name('updateUser');
    Route::get('/users/{user}/edit', [ModeratorDashboardController::class, 'editUser'])->name('editUser');
    Route::put('/users/{user}', [ModeratorDashboardController::class, 'updateUser'])->name('updateUser');
    // Moderators can ban/unban users but cannot delete or create them
    Route::post('/ban-user/{id}', [ModeratorDashboardController::class, 'banUser'])->name('banUser');
    Route::post('/unban-user/{id}', [ModeratorDashboardController::class, 'unbanUser'])->name('unbanUser');
});
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});