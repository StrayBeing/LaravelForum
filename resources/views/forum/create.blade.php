@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="display-4 mb-4">Create New Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('forum.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label fw-bold">Content</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required></textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label fw-bold">Category</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label fw-bold">Tags (select multiple)</label>
            <select name="tags[]" class="form-select" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Publish</button>
        </div>
    </form>
</div>
@endsection
