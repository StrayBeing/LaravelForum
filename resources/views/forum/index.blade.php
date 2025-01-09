@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Forum</h1>
    <form method="GET" action="{{ route('forum.index') }}">
        <input type="text" name="search" placeholder="Search posts..." value="{{ request('search') }}">
        <select name="tags[]" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <button type="submit">Search</button>
    </form>

    <ul>
    @foreach($posts as $post)
        <li>
            <a href="{{ route('forum.show', $post) }}">{{ $post->title }}</a>
            by {{ $post->user->name }}
            <div>
                Tags:
                @foreach($post->tags as $tag)
                    <span>{{ $tag->name }}</span>
                @endforeach
            </div>
        </li>
    @endforeach
</ul>
    {{ $posts->links() }}
</div>
@endsection
