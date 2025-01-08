@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Register</h1>
        <form action="{{ route('register') }}" method="POST" autocomplete="on">
            @csrf
            <input type="text" name="name" id="name" placeholder="Username" required autocomplete="name">
            <input type="email" name="email" id="email" placeholder="Email" required autocomplete="email">
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="new-password">
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
            <button type="submit">Register</button>
        </form>
    </div>
@endsection
