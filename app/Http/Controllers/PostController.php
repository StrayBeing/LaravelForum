<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
class PostController extends Controller
{
    public function create()
{
    $categories = Category::all();
    $tags = Tag::all();
    return view('forum.create', compact('categories', 'tags'));
}


public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|exists:categories,id', // Validates the category_id exists in categories table
        'tags' => 'array|exists:tags,id', // Validates that tags exist
    ]);

    // Create the post
    $post = Post::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'category_id' => $validated['category_id'],
        'user_id' => auth()->id(), // Assuming user is logged in
    ]);

    // Attach tags if any
    if (isset($validated['tags'])) {
        $post->tags()->attach($validated['tags']);
    }

    // Redirect or return response
    return redirect()->route('forum.index');
}
    
}
