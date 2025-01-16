<?php


namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
class PostController extends Controller
{
    use AuthorizesRequests;
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
public function edit(Post $post)
{
    $this->authorize('update', $post);

    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);

    $post->update($request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]));

    return redirect()->route('forum.show', $post)->with('success', 'Post updated successfully.');
}
public function destroy(Post $post)
{
    $this->authorize('delete', $post);

    $post->delete();

    return redirect()->route('forum.index')->with('success', 'Post deleted successfully.');
}

    
}
