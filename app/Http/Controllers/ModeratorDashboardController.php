<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ModeratorDashboardController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->paginate(10); // ✅ Dodaj paginację
    return view('dashboards.moderator', compact('users'));
    }

    public function editUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('moderator.dashboard')->with('error', 'You cannot edit admin users.');
        }

        return view('moderator.editUser', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('moderator.dashboard')->with('success', 'User updated successfully.');
    }

    // Handle the banning action (POST) with optional date
    public function banUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('moderator.dashboard')->with('error', 'You cannot ban admin users.');
        }

        $user->ban_status = 0;

        // If a date is set, apply it, otherwise default to 7 days
        if ($request->has('ban_until')) {
            $user->ban_until = Carbon::parse($request->ban_until);
        } else {
            $user->ban_until = Carbon::now()->addDays(7);
        }

        $user->save();

        return redirect()->route('moderator.dashboard')->with('success', 'User has been banned.');
    }

    // Unban a user
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('moderator.dashboard')->with('error', 'You cannot unban admin users.');
        }

        $user->ban_status = 1;
        $user->ban_until = null;
        $user->save();

        return redirect()->route('moderator.dashboard')->with('success', 'User has been unbanned.');
    }
}
