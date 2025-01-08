<?php

use App\Http\Controllers\AuthController;

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
