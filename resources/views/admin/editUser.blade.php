@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form method="POST" action="{{ route('admin.updateUser', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
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
            <label for="email" class="form-label">Email</label>
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

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
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
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
