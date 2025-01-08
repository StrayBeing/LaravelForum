<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return view('dashboards.admin');
            case 'moderator':
                return view('dashboards.moderator');
            default:
                return view('dashboards.user');
        }
    }
}
