<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Vote; // Dodano, jeśli Vote jest modelem
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show(User $user, Request $request)
{
    $sort = $request->get('sort', 'default'); // Default sorting
    $search = $request->get('search'); // Search term
    $tagIds = $request->get('tags'); // Tags filter
    $categoryId = $request->get('category_id'); // Category filter
    $categories = Category::all();

    // Start building the query for the posts of the specific user (could be any user, not necessarily the logged-in user)
    $query = $user->posts()
        ->with(['tags', 'category'])
        ->withCount(['votes as total_votes' => function ($query) {
            $query->select(DB::raw('SUM(vote)'));
        }])
        ->when($search, function ($query, $search) {
            // Apply search filter to title and content
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                      ->orWhere('content', 'like', "%$search%");
            });
        })
        ->when($tagIds, function ($query, $tagIds) {
            // Filter posts by tags
            $query->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            });
        })
        ->when($categoryId, function ($query, $categoryId) {
            // Filter posts by category
            $query->where('category_id', $categoryId);
        });

    // Sorting logic
    if ($sort === 'highest') {
        $query->orderByDesc('total_votes');
    } elseif ($sort === 'lowest') {
        $query->orderBy('total_votes');
    }

    // Fetch posts with pagination
    $posts = $query->paginate(10);

    // Get total votes for the user's posts
    $totalVotes = $user->posts()
        ->join('votes', 'posts.id', '=', 'votes.post_id')
        ->sum('vote');

    // Get total posts for the user's profile
    $totalPosts = $user->posts()->count();

    // Get all available tags for the search filter
    $tags = \App\Models\Tag::all();

    // Return the profile view
    return view('profile.show', compact('tags', 'user', 'posts', 'totalVotes', 'totalPosts', 'sort', 'categories'));
}



    public function vote(Request $request, $postId)
    {
        $user = auth()->user(); // Użytkownik zalogowany
        $voteValue = $request->input('vote'); // Głosowanie: 1 lub -1

        if (!in_array($voteValue, [1, -1])) {
            return redirect()->back()->with('error', 'Invalid vote value.');
        }

        $existingVote = Vote::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($existingVote) {
            $existingVote->vote = $voteValue;
            $existingVote->save();
        } else {
            Vote::create([
                'user_id' => $user->id,
                'post_id' => $postId,
                'vote' => $voteValue,
            ]);
        }

        return redirect()->route('posts.show', ['post' => $postId]);
    }
}
