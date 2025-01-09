<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag; // Include the Tag model
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Fetch posts with tags
        $posts = Post::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%$search%")
                      ->orWhere('content', 'like', "%$search%");
            })
            ->with(['user', 'tags']) // Load user and tags relationships
            ->paginate(10);
    
        // Fetch all tags for the dropdown
        $tags = Tag::all();
        return view('forum.index', compact('posts', 'search', 'tags'));
    }
    public function show($id)
    {
        // Fetch the post along with related comments and their authors
        $post = Post::with(['comments.user', 'tags', 'user'])->find($id);
    
        if (!$post) {
            return abort(404, 'Post not found');
        }
    
        return view('forum.show', compact('post')); // Pass the post to the view
    }
    
    public function addComment(Request $request, Post $post)
{
    $request->validate([
        'content' => 'required|string|max:5000',
    ]);

    $post->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->input('content'),
    ]);

    return redirect()->route('forum.show', $post)->with('success', 'Comment added successfully.');
}


}
