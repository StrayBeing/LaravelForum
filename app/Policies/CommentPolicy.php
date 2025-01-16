<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment)
    {
        // Właściciel komentarza, moderator lub admin może edytować komentarz
        return $user->id === $comment->user_id || $user->role === 'admin' || $user->role === ('moderator');
    }

    public function delete(User $user, Comment $comment)
    {
        // Właściciel komentarza, moderator lub admin może usunąć komentarz
        return $user->id === $comment->user_id || $user->role === 'admin' || $user->role === ('moderator');
    }
}
