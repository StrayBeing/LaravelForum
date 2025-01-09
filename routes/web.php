<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
// Strony logowania i rejestracji
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Strona główna
Route::get('/', function () {
    return view('welcome');  // Strona główna witryny
})->name('welcome');

// Dashboard
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return view('dashboard.admin');
    } elseif (auth()->user()->role === 'moderator') {
        return view('dashboard.moderator');
    } else {
        return view('dashboard.user');
    }
})->middleware('auth')->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/{post}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/{post}/vote', [ForumController::class, 'vote'])->name('forum.vote');
    Route::post('/forum/{post}/comment', [ForumController::class, 'addComment'])->name('forum.comment');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/post/{postId}/vote', [VoteController::class, 'vote'])->name('vote');
});