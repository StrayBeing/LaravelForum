@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin! Manage users and forum activities here.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
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
                            <span class="badge badge-success">Unbanned</span>
                        @else
                            <span class="badge badge-danger">Banned</span>
                        @endif
                    </td>
                    <td>
                        @if($user->ban_status == 1)
                            <!-- Form for banning the user -->
                            <form action="{{ route('admin.banUser', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-warning">Ban</button>
                            </form>
                        @else
                            <!-- Form for unbanning the user -->
                            <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success">Unban</button>
                            </form>
                        @endif

                        <!-- Form for setting ban duration -->
                        @if($user->ban_status == 1)
                            <form action="{{ route('admin.banUser', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <label for="ban_until">Ban Until:</label>
                                <input type="date" name="ban_until" required>
                                <button type="submit" class="btn btn-warning">Set Ban</button>
                            </form>
                        @endif

                        <!-- Form for deleting a user -->
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
