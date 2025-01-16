@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="display-4 mb-4">Create New User</h1>

    <form method="POST" action="{{ route('admin.storeUser') }}" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
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
                value="{{ old('email') }}" 
                required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label fw-bold">Role</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control @error('password') is-invalid @enderror" 
                required>
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
                class="form-control" 
                required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Create User</button>
        </div>
    </form>
</div>
@endsection
