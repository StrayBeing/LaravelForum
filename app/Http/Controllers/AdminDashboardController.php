<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('dashboards.admin', compact('users'));
    }

    // Show the form to ban a user (GET)
    public function showBanForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.banUserForm', compact('user'));
    }

    // Handle the banning action (POST)
    public function banUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Set the user's ban status to banned (0)
        $user->ban_status = 0;

        // Set the ban duration, either from the form input or default to 7 days
        if ($request->has('ban_until')) {
            $user->ban_until = Carbon::parse($request->ban_until);
        } else {
            $user->ban_until = Carbon::now()->addDays(7); // Default ban duration (7 days)
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User has been banned.');
    }

    // Unban a user
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->ban_status = 1; // Set ban status to unbanned (1)
        $user->ban_until = null; // Remove the ban end date
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User has been unbanned.');
    }

    // Delete a user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User has been deleted.');
    }
    public function editUser(User $user)
{
    return view('admin.editUser', compact('user'));
}
public function updateUser(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,moderator,user',
        'password' => 'nullable|min:8|confirmed', // Opcjonalne pole hasła
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role = $validated['role'];

    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']); // Hashowanie hasła
    }

    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
}
public function createUserForm()
{
    return view('admin.createUser');
}
public function storeUser(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'role' => 'required|in:admin,moderator,user',
        'password' => 'required|min:8|confirmed',
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => bcrypt($validated['password']), // Hashowanie hasła
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'User created successfully.');
}

}
