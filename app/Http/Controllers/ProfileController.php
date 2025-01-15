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
    $sort = $request->get('sort', 'default'); // Default sort is no sorting
    $search = $request->get('search'); // Search term
    $tagIds = $request->get('tags'); // Tags filter
    $categoryId = $request->get('category_id'); // Category filter
    $categories = Category::all();

    // Budowanie zapytania
    $query = $user->posts()
        ->with(['tags', 'category'])
        ->withCount(['votes as total_votes' => function ($query) {
            $query->select(DB::raw('SUM(vote)'));
        }])
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
        })
        ->when($tagIds, function ($query, $tagIds) {
            $query->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            });
        })
        ->when($categoryId, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        });

    // Obsługa sortowania
    if ($sort === 'highest') {
        $query->orderByDesc('total_votes'); // Sortowanie malejąco po głosach
    } elseif ($sort === 'lowest') {
        $query->orderBy('total_votes'); // Sortowanie rosnąco po głosach
    }

    // Wykonanie zapytania z paginacją
    $posts = $query->paginate(10); // Dodajemy paginację

    // Pobieramy łączną liczbę głosów i postów
    $totalVotes = $user->posts()
        ->join('votes', 'posts.id', '=', 'votes.post_id')
        ->sum('vote');

    $totalPosts = $user->posts()->count();

    // Pobieramy tagi do widoku
    $tags = \App\Models\Tag::all();

    // Zwracamy widok
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
