@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="display-4 mb-4">Admin Dashboard</h1>
    <p class="lead">Welcome, Admin! Manage users and forum activities here.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create User Button -->
    <div class="mb-4">
        <a href="{{ route('admin.createUserForm') }}" class="btn btn-success px-4">Create New User</a>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Users Management</h5>
        </div>
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Ban Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            @if($user->ban_status == 1)
                                <span class="badge bg-success">Unbanned</span>
                            @else
                                <span class="badge bg-danger">Banned</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                @if($user->ban_status == 1)
                                    <form action="{{ route('admin.banUser', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="date" name="ban_until" class="form-control form-control-sm d-inline w-auto" required>
                                        <button type="submit" class="btn btn-warning btn-sm">Ban</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Unban</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
