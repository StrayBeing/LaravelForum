<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Sprawdzenie, czy użytkownik może edytować post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->role === 'admin' || 
               $user->role === 'moderator' || 
               $user->id === $post->user_id;
    }

    /**
     * Sprawdzenie, czy użytkownik może usunąć post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->role === 'admin' || 
               $user->role === 'moderator' || 
               $user->id === $post->user_id;
    }
}
