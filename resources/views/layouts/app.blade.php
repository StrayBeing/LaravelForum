<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <!-- Top navigation bar -->
    <nav class="navbar">
        <div class="container navbar-container">
            <!-- Logo -->
            <div class="navbar-logo">
                <a href="{{ url('/') }}">MyForum</a>
            </div>

            <!-- Navigation Links -->
            <ul class="navbar-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('forum.index') }}">Forum</a></li>
                    <li><a href="{{ route('profile.show', auth()->user()->id) }}">Profile</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="logout-button">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Notifications (Optional) -->
    @auth
    <div class="notifications">
        @if (session('status'))
            <div class="notification-message">
                {{ session('status') }}
            </div>
        @endif
    </div>
    @endauth

    <!-- Main content -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} MyForum. All rights reserved.</p>
        </div>
    </footer>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
