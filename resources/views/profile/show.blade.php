@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Profile Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4">{{ $user->name }}'s Profile</h1>
        <div>
            <p class="mb-1"><strong>Total Posts:</strong> {{ $totalPosts }}</p>
            <p class="mb-0"><strong>Total Votes:</strong> {{ $totalVotes }}</p>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('profile.show', $user->id) }}" class="card p-4 mb-4 shadow-sm">
        <h5 class="mb-3">Search Posts</h5>
        <div class="row g-3">
            <!-- Search Input -->
            <div class="col-md-6">
                <input type="text" name="search" placeholder="Search posts..." value="{{ request('search') }}" class="form-control" />
            </div>

            <!-- Tags Multi-Select -->
            <div class="col-md-6">
                <select name="tags[]" multiple class="form-select">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if(request('tags') && in_array($tag->id, request('tags'))) selected @endif>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Category Dropdown -->
            <div class="col-md-6">
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Dropdown -->
            <div class="col-md-6">
                <select name="sort" class="form-select">
                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Default</option>
                    <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Votes</option>
                    <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Votes</option>
                </select>
            </div>
        </div>

        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Posts List -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Posts</h5>
        </div>
        <ul class="list-group list-group-flush">
            @forelse($posts as $post)
                <li class="list-group-item">
                    <h5>
                        <a href="{{ route('forum.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a>
                    </h5>
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Category:</strong> {{ $post->category->name ?? 'None' }}
                        </div>
                        <div>
                            <strong>Votes:</strong> {{ $post->total_votes }}
                        </div>
                    </div>
                    <div class="mt-2">
                        <strong>Tags:</strong>
                        @foreach($post->tags as $tag)
                            <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">No posts found.</li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
