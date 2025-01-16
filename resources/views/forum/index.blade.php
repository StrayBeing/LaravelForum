@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="display-4 mb-4">Forum</h1>

    <!-- Create Post Button -->
    <div class="mb-4 text-end">
        <a href="{{ route('forum.create') }}" class="btn btn-primary px-4">Create Post</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('forum.index') }}" class="card p-4 shadow-sm mb-4">
        <h5 class="mb-3">Search Posts</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" placeholder="Search posts..." value="{{ request('search') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <select name="tags[]" multiple class="form-select">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if(request('tags') && in_array($tag->id, request('tags'))) selected @endif>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>
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
            <div class="col-md-6 text-end">
                <button type="submit" class="btn btn-secondary px-4">Search</button>
            </div>
        </div>
    </form>

    <!-- Posts List -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Posts</h5>
        </div>
        <ul class="list-group list-group-flush">
            @foreach($posts as $post)
                <li class="list-group-item">
                    <h5><a href="{{ route('forum.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a></h5>
                    <p>by <a href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a></p>
                    <p><strong>Category:</strong> {{ $post->category->name }}</p>
                    <div>
                        <strong>Tags:</strong>
                        @foreach($post->tags as $tag)
                            <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
