<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum')</title>
    <script>
    // Sprawdzamy, czy użytkownik ma zapisane preferencje w localStorage
    let savedDarkMode = localStorage.getItem('dark-mode');

    // Jeśli użytkownik ma ustawiony tryb ciemny, dodajemy klasę 'dark-mode' do body
    if (savedDarkMode === 'enabled') {
        document.body.classList.add('dark-mode');
    }

    // Dodajemy klasę 'loading' do body, aby ukryć stronę podczas ładowania
    document.body.classList.add('loading');
</script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body.loading {
    visibility: hidden;
}
        body {
            font-size: 16px;
            background-color: #f8f9fa;
            color: #212529;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode .list-group-item {
            background-color: #495057;
            color: #f8f9fa;
        }

        body.dark-mode .list-group-item a {
            color: #d1d1d1;
        }

        body.dark-mode .list-group-item a:hover {
            color: #a8a8a8;
        }

        body.dark-mode .list-group-item textarea {
            background-color: #495057;
            color: #f8f9fa;
            border-color: #6c757d;
        }

        body.dark-mode .card {
            background-color: #343a40;
            color: #f8f9fa;
        }

        body.dark-mode .card-header {
            background-color: #495057;
            color: #f8f9fa;
        }

        body.dark-mode .table {
            background-color: #343a40;
            color: #f8f9fa;
        }

        body.dark-mode .table th, body.dark-mode .table td {
            border-color: #6c757d;
        }

        body.dark-mode .table th {
            background-color: #495057;
            color: #f8f9fa;
        }

        body.dark-mode .table-hover tbody tr:hover {
            background-color: #495057;
        }

        body.dark-mode .btn-primary, body.dark-mode .btn-success, body.dark-mode .btn-danger, body.dark-mode .btn-warning {
            background-color: #007bff;
        }

        body.dark-mode .btn-primary:hover, body.dark-mode .btn-success:hover, body.dark-mode .btn-danger:hover, body.dark-mode .btn-warning:hover {
            background-color: #0056b3;
        }

        body.dark-mode .pagination .page-item .page-link {
            background-color: #495057;
            color: #f8f9fa;
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
        }

        body.dark-mode .pagination .page-item .page-link:hover {
            background-color: #6c757d;
        }

        .accessibility-menu {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 60px;
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        body.dark-mode .list-group-item {
            background-color: #495057;
            color: #f8f9fa;
        }

        body.dark-mode .list-group-item a {
            color: #007bff;
        }

        body.dark-mode .list-group-item a:hover {
            color: #0056b3;
        }

        body.dark-mode .list-group-item textarea {
            background-color: #495057;
            color: #f8f9fa;
            border-color: #6c757d;
        }

        .accessibility-menu button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        body.dark-mode .navbar .nav-link {
            color: #f8f9fa;
        }

        body.dark-mode .navbar .nav-link:hover {
            color: #007bff;
        }

        .accessibility-menu button:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        .accessibility-menu button:focus {
            outline: 2px solid #ffcc00;
        }

        .accessibility-menu .close-btn {
            background-color: #dc3545;
        }

        .accessibility-menu .close-btn:hover {
            background-color: #a71d2a;
        }

        .large-font {
            font-size: 18px;
        }

        .extra-large-font {
            font-size: 20px;
        }

        .extra-large-font-2 {
            font-size: 22px;
        }

        body.dark-mode {
            background-color: #343a40;
            color: #f8f9fa;
        }

        body.dark-mode .navbar {
            background-color: #495057 !important;
        }

        body.dark-mode .navbar a {
            color: #f8f9fa;
        }

        body.dark-mode .navbar a:hover {
            color: #007bff;
        }

        body.dark-mode .footer {
            background-color: #495057 !important;
            color: #f8f9fa;
        }

        body.dark-mode .footer a {
            color: #f8f9fa;
        }

        body.dark-mode .footer a:hover {
            color: #007bff;
        }

        body.dark-mode input,
        body.dark-mode textarea,
        body.dark-mode select,
        body.dark-mode button {
            background-color: #495057;
            color: #f8f9fa;
            border: 1px solid #6c757d;
        }

        body.dark-mode input:focus,
        body.dark-mode textarea:focus,
        body.dark-mode select:focus {
            border-color: #007bff;
        }

        body.dark-mode .btn {
            background-color: #007bff;
            color: white;
        }

        body.dark-mode .btn:hover {
            background-color: #0056b3;
        }

        body.dark-mode a {
            color: #007bff;
        }

        body.dark-mode a:hover {
            color: #0056b3;
        }

        body.dark-mode h5,
        body.dark-mode .card-header {
            color: #f8f9fa;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #495057;
            color: #f8f9fa;
            border: 1px solid #6c757d;
        }

        body.dark-mode ul {
            color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .accessibility-menu {
                top: 5px;
                right: 5px;
                width: 50px;
                gap: 8px;
            }

            .accessibility-menu button {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <!-- Accessibility Menu -->
    <div class="accessibility-menu" id="accessibility-controls">
        <button id="increase-font" aria-label="Increase font size">A+</button>
        <button id="decrease-font" aria-label="Decrease font size">A-</button>
        <button id="toggle-dark-mode" aria-label="Toggle dark mode">🌙</button>
        <button class="close-btn" id="toggle-accessibility" aria-label="Close Accessibility Controls">&times;</button>
    </div>

    <!-- Top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">MyForum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mx-auto" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route(auth()->user()->role . '.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('forum.index') }}">Forum</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.show', auth()->user()->id) }}">Profile</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Notifications -->
    @auth
    <div class="notifications">
        @if (session('status'))
            <div class="alert alert-info">
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
    <footer class="footer bg-light py-3">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} MyForum. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
       $(document).ready(function() {
    // Usuń klasę loading po załadowaniu preferencji
    $('body').removeClass('loading');

    // Sprawdzamy, czy użytkownik ma zapisane preferencje w localStorage
    let savedDarkMode = localStorage.getItem('dark-mode');
    let savedFontSize = localStorage.getItem('font-size');
    
    // Zastosuj zapisane preferencje czcionki
    if (savedFontSize) {
        $('body').addClass(savedFontSize);
    }

    // Zastosuj preferencje dark mode
    if (savedDarkMode === 'enabled') {
        $('body').addClass('dark-mode');
    } else if (savedDarkMode === 'disabled') {
        $('body').removeClass('dark-mode');
    }

    // Zwiększanie czcionki
    $('#increase-font').click(function() {
        let currentFontSize = localStorage.getItem('font-size');
        if (currentFontSize === 'large') {
            $('body').removeClass('large-font').addClass('extra-large-font');
            localStorage.setItem('font-size', 'extra-large');
        } else if (currentFontSize === 'extra-large') {
            $('body').removeClass('extra-large-font').addClass('extra-large-font-2');
            localStorage.setItem('font-size', 'extra-large-2');
        }
    });

    // Zmniejszanie czcionki
    $('#decrease-font').click(function() {
        let currentFontSize = localStorage.getItem('font-size');
        if (currentFontSize === 'extra-large-2') {
            $('body').removeClass('extra-large-font-2').addClass('extra-large-font');
            localStorage.setItem('font-size', 'extra-large');
        } else if (currentFontSize === 'extra-large') {
            $('body').removeClass('extra-large-font').addClass('large-font');
            localStorage.setItem('font-size', 'large');
        }
    });

    // Przełączanie Dark Mode
    $('#toggle-dark-mode').click(function() {
        $('body').toggleClass('dark-mode');
        if ($('body').hasClass('dark-mode')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    });

    // Toggle Accessibility Menu
    $('#toggle-accessibility').click(function() {
        $('#accessibility-controls').toggle();
    });
});
    </script>
</body>
</html>
