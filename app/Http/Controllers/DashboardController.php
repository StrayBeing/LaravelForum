<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                $users = User::all(); // Fetch all users for admin
                return view('dashboards.admin', compact('users'));
            case 'moderator':
                return view('dashboards.moderator');
            default:
                return view('dashboards.user');
        }
    }
}
