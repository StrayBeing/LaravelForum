@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Login</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autocomplete="email" autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
@endsection
