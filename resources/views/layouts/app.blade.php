<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
