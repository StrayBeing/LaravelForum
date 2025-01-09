<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller
{
    public function show(User $user, Request $request)
{
    $sort = $request->get('sort', 'default'); // Default sort is no sorting

    $posts = $user->posts()
        ->withCount(['votes as total_votes' => function ($query) {
            $query->select(DB::raw('SUM(vote)'));
        }])
        ->when($sort === 'highest', function ($query) {
            $query->orderBy('total_votes', 'desc');
        })
        ->when($sort === 'lowest', function ($query) {
            $query->orderBy('total_votes', 'asc');
        })
        ->paginate(10);

    $totalVotes = $user->posts()
        ->join('votes', 'posts.id', '=', 'votes.post_id')
        ->sum('vote');

    $totalPosts = $user->posts()->count();

    return view('profile.show', compact('user', 'posts', 'totalVotes', 'totalPosts', 'sort'));
}
public function vote(Request $request, $postId)
{
    $user = auth()->user(); // Assuming the user is logged in
    $voteValue = $request->input('vote'); // Should be either 1 (upvote) or -1 (downvote)

    // Validate the vote value
    if (!in_array($voteValue, [1, -1])) {
        return redirect()->back()->with('error', 'Invalid vote value.');
    }

    // Check if the user has already voted on this post
    $existingVote = Vote::where('user_id', $user->id)->where('post_id', $postId)->first();

    if ($existingVote) {
        // Update the existing vote if it already exists
        $existingVote->vote = $voteValue;
        $existingVote->save();
    } else {
        // Otherwise, create a new vote
        Vote::create([
            'user_id' => $user->id,
            'post_id' => $postId,
            'vote' => $voteValue,
        ]);
    }

    return redirect()->route('posts.show', ['post' => $postId]); // Redirect to the post's page
}
}