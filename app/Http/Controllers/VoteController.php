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
    $voteValue = $request->input('vote'); // 1 for upvote, -1 for downvote

    // Validate vote value
    if (!in_array($voteValue, [1, -1])) {
        return redirect()->back()->with('error', 'Invalid vote value.');
    }

    // Check if the user has already voted on this post
    $existingVote = Vote::where('user_id', $user->id)
                        ->where('post_id', $postId)
                        ->first();

    if ($existingVote) {
        if ($existingVote->vote == $voteValue) {
            // Unvote if the same button is clicked again
            $existingVote->delete();
        } else {
            // Change the vote
            $existingVote->vote = $voteValue;
            $existingVote->save();
        }
    } else {
        // Create a new vote
        Vote::create([
            'user_id' => $user->id,
            'post_id' => $postId,
            'vote' => $voteValue,
        ]);
    }

    return redirect()->route('forum.show', ['post' => $postId])->with('success', 'Your vote has been recorded.');
}

}
