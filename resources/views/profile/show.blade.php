@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>
    <p>Total Posts: {{ $totalPosts }}</p>
    <p>Total Votes: {{ $totalVotes }}</p>

    <!-- Search Form -->
    <form method="GET" action="{{ route('profile.show', $user->id) }}" class="mb-4">
        <input type="text" name="search" placeholder="Search posts..." value="{{ request('search') }}" class="form-control mb-2">
        
        <select name="tags[]" multiple class="form-control mb-2">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" @if(request('tags') && in_array($tag->id, request('tags'))) selected @endif>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>

        <select name="category_id" class="form-control mb-2">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="form-control mb-2">
            <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Default</option>
            <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Votes</option>
            <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Votes</option>
        </select>

        <button type="submit" class="btn btn-secondary">Search</button>
    </form>

    <!-- Posts List -->
    <ul class="list-group">
        @foreach($posts as $post)
            <li class="list-group-item">
                <a href="{{ route('forum.show', $post) }}">{{ $post->title }}</a>
                <div>
                    <strong>Category:</strong> {{ $post->category->name ?? 'None' }}
                </div>
                <div>
                    <strong>Tags:</strong>
                    @foreach($post->tags as $tag)
                        <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div>
                    <strong>Votes:</strong> {{ $post->total_votes }}
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
