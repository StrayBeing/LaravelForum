<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts; // Pobieranie postów użytkownika za pomocą relacji

        return view('profile.show', compact('user', 'posts'));
    }
}