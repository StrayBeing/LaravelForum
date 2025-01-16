@extends('layouts.app')

@section('content')
<div class="container">
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

    <h1>{{ $post->title }}</h1>
    <p>By <a href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a></p>
    <p>{{ $post->content }}</p>
    <div>
        Tags:
        @foreach($post->tags as $tag)
            <span>{{ $tag->name }}</span>
        @endforeach
    </div>

    <div>
    <form method="POST" action="{{ route('vote', ['postId' => $post->id]) }}">
        @csrf
        <!-- Highlight the upvote or downvote button based on the user's vote -->
        @php
            $userVote = auth()->user()->votes()->where('post_id', $post->id)->first();
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


    <div>
        <p>Total Votes: {{ $post->totalVotes }}</p>
    </div>

    <h3>Comments</h3>
<form method="POST" action="{{ route('forum.comment', $post) }}">
    @csrf
    <textarea name="content" rows="4" class="form-control" placeholder="Write your comment..."></textarea>
    <button type="submit" class="btn btn-primary mt-2">Comment</button>
</form>


    <ul>
        @foreach($post->comments as $comment)
            <li>
                {{ $comment->content }} by <a href="{{ route('profile.show', $comment->user) }}">{{ $comment->user->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection