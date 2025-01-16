@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="display-4 mb-4">Edit User</h1>

    <form method="POST" action="{{ route('moderator.updateUser', $user->id) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $user->name) }}" 
                required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $user->email) }}" 
                required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Role field is hidden -->
        <input type="hidden" name="role" value="{{ $user->role }}">

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password (optional)</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="form-control">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Update User</button>
        </div>
    </form>
</div>
@endsection
