@extends('layouts.app')

@section('content')
<div class="container">
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
            <!-- Display current vote status -->
            @if(auth()->user()->hasVotedOnPost($post->id))
                <p>You have voted on this post.</p>
            @else
                <button name="vote" value="1">Upvote</button>
                <button name="vote" value="-1">Downvote</button>
            @endif
        </form>
    </div>

    <div>
        <p>Total Votes: {{ $post->totalVotes }}</p>
    </div>

    <h3>Comments</h3>
    <form method="POST" action="{{ route('forum.comment', $post) }}">
        @csrf
        <textarea name="content"></textarea>
        <button type="submit">Comment</button>
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
