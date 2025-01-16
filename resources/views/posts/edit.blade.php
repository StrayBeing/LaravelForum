@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4">Edit Post</h1>
    </div>

    <!-- Edit Post Form -->
    <form method="POST" action="{{ route('forum.update', $post) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <!-- Title Field -->
        <div class="mb-4">
            <label for="title" class="form-label fw-bold">Title</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control @error('title') is-invalid @enderror" 
                value="{{ old('title', $post->title) }}" 
                required
            >
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Content Field -->
        <div class="mb-4">
            <label for="content" class="form-label fw-bold">Content</label>
            <textarea 
                name="content" 
                id="content" 
                rows="6" 
                class="form-control @error('content') is-invalid @enderror" 
                required
            >{{ old('content', $post->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
            <a href="{{ route('forum.index') }}" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
@endsection
