@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Register</h1>
        <form action="{{ route('register') }}" method="POST" autocomplete="on">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your username" required autocomplete="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autocomplete="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
@endsection
