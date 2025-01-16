@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Moderator Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Ban Until</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->ban_status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Banned</span>
                        @endif
                    </td>
                    <td>
                        @if($user->ban_until)
                            {{ \Carbon\Carbon::parse($user->ban_until)->format('Y-m-d') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($user->ban_status == 1)
                            <!-- Ban User Form with Date -->
                            <form action="{{ route('moderator.banUser', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <label for="ban_until">Ban Until:</label>
                                <input type="date" name="ban_until" required>
                                <button type="submit" class="btn btn-warning btn-sm">Ban</button>
                            </form>
                        @else
                            <!-- Unban User Form -->
                            <form action="{{ route('moderator.unbanUser', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Unban</button>
                            </form>
                        @endif

                        <!-- Edit User Button -->
                        <a href="{{ route('moderator.editUser', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
    {{ $users->links() }}
</div>
</div>
@endsection
