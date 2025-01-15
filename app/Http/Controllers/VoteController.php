<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Post;

class VoteController extends Controller
{
    public function vote(Request $request, $postId)
    {
        $user = auth()->user();
        $voteValue = (int) $request->input('vote'); // Ensure it's an integer
    
        if (!in_array($voteValue, [1, -1])) {
            return redirect()->back()->with('error', 'Invalid vote value.');
        }
    
        $existingVote = Vote::where('user_id', $user->id)
                            ->where('post_id', $postId)
                            ->first();
    
        if ($existingVote) {
            if ($existingVote->vote === $voteValue) {
                // If the same vote is clicked again, remove the vote
                $existingVote->delete();
            } else {
                // If switching votes, update the vote value
                $existingVote->update(['vote' => $voteValue]);
            }
        } else {
            // If no existing vote, create a new one
            Vote::create([
                'user_id' => $user->id,
                'post_id' => $postId,
                'vote' => $voteValue,
            ]);
        }
    
        return redirect()->route('forum.show', ['post' => $postId])->with('success', 'Your vote has been recorded.');
    }
    
}