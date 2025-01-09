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
        $post = Post::find($id); // Fetch the post by ID

        if (!$post) {
            return abort(404, 'Post not found'); // Handle case where post doesn't exist
        }

        return view('forum.show', compact('post')); // Return the view with the post data
    }
    
}
