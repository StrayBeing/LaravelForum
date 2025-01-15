<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon; // Dodajemy Carbon, aby obsługiwać daty

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Create the new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);
    
        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
{
    // Validate input fields
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to login user
    $user = User::where('email', $request->email)->first();

    // Check if user exists and if they are banned
    if ($user && $user->ban_status == 0) {
        // Check if the ban is still active
        if ($user->ban_until && Carbon::now()->lt(Carbon::parse($user->ban_until))) {
            // If the ban is still active, deny login and return a message
            return back()->withErrors(['email' => 'Your account is banned until ' . Carbon::parse($user->ban_until)->toDateString() . '.'])->withInput();
        }
    }

    // Attempt login if user is not banned or the ban has expired
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route('dashboard')->with('success', 'Logged in successfully.');
    }

    // If login fails
    return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
}

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
