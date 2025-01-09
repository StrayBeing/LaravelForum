@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>
    <h3>Posts</h3>
    <ul>
        @foreach($posts as $post)
            <li>
                <a href="{{ route('forum.show', $post) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection