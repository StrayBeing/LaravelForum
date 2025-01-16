<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* Default Styles */
        body {
            font-size: 16px;
            background-color: #f8f9fa;
            color: #212529;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* Added smooth transition for theme change */
        }

        .large-font { font-size: 18px; }
        .extra-large-font { font-size: 20px; }
        .extra-large-font-2 { font-size: 22px; }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #343a40;
            color: #f8f9fa;
        }

        /* Dark Mode for navbar */
        body.dark-mode .navbar {
            background-color: #495057;
            color: #f8f9fa;
        }

        body.dark-mode .navbar-nav .nav-link {
            color: #f8f9fa;
        }

        body.dark-mode .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        /* Dark Mode for buttons */
        body.dark-mode .btn {
            background-color: #007bff;
            color: #ffffff;
        }

        body.dark-mode .btn:hover {
            background-color: #0056b3;
        }

        /* Dark Mode for form elements */
        body.dark-mode input, body.dark-mode textarea, body.dark-mode select {
            background-color: #495057;
            color: #f8f9fa;
            border-color: #6c757d;
        }

        /* Dark Mode for links */
        body.dark-mode a {
            color: #f8f9fa;
        }

        body.dark-mode a:hover {
            color: #007bff;
        }

        /* Dark Mode for footer */
        body.dark-mode .footer {
            background-color: #495057;
            color: #f8f9fa;
        }

        /* Dark Mode Styles for Accessibility Controls */
        body.dark-mode .accessibility-controls {
            background-color: #495057;
            color: #f8f9fa;
        }

        /* Accessibility Controls */
        .accessibility-controls {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 60px;
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        .accessibility-controls button {
            margin: 5px;
            padding: 12px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            width: 50px;
            height: 50px;
        }

        .accessibility-controls button:hover {
            background-color: #0056b3;
        }

        .accessibility-controls button:focus {
            outline: 2px solid #ffcc00; /* Adds a yellow outline on focus for accessibility */
        }

        .accessibility-controls .close-btn {
            font-size: 24px;
            background-color: red;
            border-radius: 50%;
            padding: 5px;
        }

        /* Responsive for smaller screens */
        @media (max-width: 768px) {
            .accessibility-controls {
                position: fixed;
                top: 5px;
                right: 5px;
                z-index: 9999;
            }

            /* Adjust navbar font size on smaller screens */
            .navbar {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <!-- Accessibility Controls -->
    <div class="accessibility-controls" id="accessibility-controls">
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
    
    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Check localStorage for saved preferences
            let fontSize = localStorage.getItem('font-size');
            if (fontSize === 'large') {
                $('body').addClass('large-font');
            } else if (fontSize === 'extra-large') {
                $('body').addClass('extra-large-font');
            } else if (fontSize === 'extra-large-2') {
                $('body').addClass('extra-large-font-2');
            }

            let darkMode = localStorage.getItem('dark-mode');
            if (darkMode === 'enabled') {
                $('body').addClass('dark-mode');
            }

            // Increase Font Size
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

            // Decrease Font Size
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

            // Toggle Dark Mode
            $('#toggle-dark-mode').click(function() {
                $('body').toggleClass('dark-mode');
                if ($('body').hasClass('dark-mode')) {
                    localStorage.setItem('dark-mode', 'enabled');
                } else {
                    localStorage.setItem('dark-mode', 'disabled');
                }
            });

            // Toggle Accessibility Controls visibility
            $('#toggle-accessibility').click(function() {
                $('#accessibility-controls').toggleClass('d-none');
            });
        });
    </script>
</body>
</html>
