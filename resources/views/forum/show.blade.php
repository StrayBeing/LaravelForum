@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if(Auth::check() && (Auth::user()->can('update', $post) || Auth::user()->can('delete', $post)))
        <div class="mt-3">
            @can('update', $post)
                <a href="{{ route('forum.edit', $post) }}" class="btn btn-primary">Edit</a>
            @endcan

            @can('delete', $post)
                <form method="POST" action="{{ route('forum.destroy', $post) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endcan
        </div>
    @endif

    <h1 class="display-4 mb-4">{{ $post->title }}</h1>
    <p class="lead">By <a href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a></p>
    <p>{{ $post->content }}</p>

    <div class="mb-4">
        <strong>Tags:</strong>
        @foreach($post->tags as $tag)
            <span class="badge bg-info text-dark">{{ $tag->name }}</span>
        @endforeach
    </div>

    <div class="mb-4">
        <p>Total Votes: {{ $post->totalVotes }}</p>
        <form method="POST" action="{{ route('vote', ['postId' => $post->id]) }}">
            @csrf
            @php
                $userVote = auth()->check() ? auth()->user()->votes()->where('post_id', $post->id)->first() : null;
                $upvoted = $userVote && $userVote->vote === 1;
                $downvoted = $userVote && $userVote->vote === -1;
            @endphp

            <button 
                name="vote" 
                value="1" 
                class="btn {{ $upvoted ? 'btn-success' : 'btn-secondary' }}">
                Upvote
            </button>

            <button 
                name="vote" 
                value="-1" 
                class="btn {{ $downvoted ? 'btn-danger' : 'btn-secondary' }}">
                Downvote
            </button>
        </form>
    </div>

    <h3>Comments</h3>
    <form method="POST" action="{{ route('forum.comment', $post) }}" class="mb-4">
        @csrf
        <textarea name="content" rows="4" class="form-control mb-2" placeholder="Write your comment..."></textarea>
        <button type="submit" class="btn btn-primary">Comment</button>
    </form>

    <ul class="list-group">
        @foreach($comments as $comment)
            <li class="list-group-item">
                <p>{{ $comment->content }}</p>
                <small>
                    By <a href="{{ route('profile.show', $comment->user) }}">{{ $comment->user->name }}</a>
                    on {{ $comment->created_at->format('Y-m-d H:i') }}
                </small>
                @if($comment->edited_at)
                    <small>(edited at {{ \Carbon\Carbon::parse($comment->edited_at)->format('Y-m-d H:i') }})</small>
                @endif

                @can('update', $comment)
                    <form method="POST" action="{{ route('forum.editComment', ['post' => $post->id, 'commentId' => $comment->id]) }}" class="mt-2">
                        @csrf
                        @method('PUT')
                        <textarea name="content" rows="2" class="form-control">{{ $comment->content }}</textarea>
                        <button type="submit" class="btn btn-primary mt-1">Update</button>
                    </form>
                @endcan

                @can('delete', $comment)
                    <form method="POST" action="{{ route('forum.destroyComment', ['post' => $post->id, 'commentId' => $comment->id]) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endcan
            </li>
        @endforeach
    </ul>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $comments->links() }}
    </div>
</div>
@endsection
