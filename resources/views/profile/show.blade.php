@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>

    <!-- Informacje ogólne -->
    <div class="profile-summary">
        <p>Total Posts: {{ $totalPosts }}</p>
        <p>Total Votes: {{ $totalVotes }}</p>
    </div>

    <!-- Sortowanie -->
    <form method="GET" action="{{ route('profile.show', $user) }}">
        <label for="sort">Sort posts by:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="default" {{ $sort === 'default' ? 'selected' : '' }}>Default</option>
            <option value="highest" {{ $sort === 'highest' ? 'selected' : '' }}>Highest Votes</option>
            <option value="lowest" {{ $sort === 'lowest' ? 'selected' : '' }}>Lowest Votes</option>
        </select>
    </form>

    <!-- Lista postów -->
    <h3>Posts</h3>
    <ul>
        @foreach($posts as $post)
            <li>
                <a href="{{ route('forum.show', $post) }}">{{ $post->title }}</a>
                <span>- Total Votes: {{ $post->total_votes ?? 0 }}</span>
            </li>
        @endforeach
    </ul>

    <!-- Paginacja -->
    {{ $posts->links() }}
</div>
@endsection
