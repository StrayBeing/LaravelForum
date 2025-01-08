@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Login</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" id="email" placeholder="Email" required autocomplete="email" autofocus>
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
            <button type="submit">Login</button>
        </form>
    </div>
@endsection
