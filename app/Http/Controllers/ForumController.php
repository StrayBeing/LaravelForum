<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ForumController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
{
    $search = $request->query('search');
    $tagIds = $request->query('tags');
    $categoryId = $request->query('category_id');

    // Pobieranie postów z filtrami
    $posts = Post::query()
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
        })
        ->with(['user', 'tags', 'category'])
        ->paginate(10);

    // Pobieranie wszystkich tagów i kategorii
    $categories = Category::all();
    $tags = Tag::all();

    return view('forum.index', compact('posts', 'search', 'tags', 'categories'));
}


    public function show($id)
    {
        // Pobranie posta z komentarzami, tagami i autorem
        $post = Post::with(['comments.user', 'tags', 'user', 'category'])->find($id);

        if (!$post) {
            return abort(404, 'Post not found');
        }

        return view('forum.show', compact('post'));
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);
    
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
            'created_at' => now(),
        ]);
    
        return redirect()->route('forum.show', $post)->with('success', 'Comment added successfully.');
    }
    public function editComment(Request $request, Post $post, $commentId)
{
    $comment = $post->comments()->where('id', $commentId)->first();

    if (!$comment) {
        return abort(404, 'Comment not found.');
    }

    // Sprawdzenie uprawnień
    $this->authorize('update', $comment);

    $request->validate([
        'content' => 'required|string|max:5000',
    ]);

    $comment->update([
        'content' => $request->input('content'),
        'edited_at' => now(),
        'edited_by' => auth()->id(),
    ]);

    return redirect()->route('forum.show', $post)->with('success', 'Comment updated successfully.');
}
public function destroyComment(Post $post, $commentId)
{
    $comment = $post->comments()->where('id', $commentId)->first();

    if (!$comment) {
        return abort(404, 'Comment not found.');
    }

    // Sprawdzenie uprawnień
    $this->authorize('delete', $comment);

    $comment->delete();

    return redirect()->route('forum.show', $post)->with('success', 'Comment deleted successfully.');
}
}
