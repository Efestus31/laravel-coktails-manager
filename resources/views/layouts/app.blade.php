<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cocktail App') }}</title>
    <style>
        /* Centra sempre la pagination */
        .pagination {
            display: flex !important;
            justify-content: center !important;
            margin: 0 auto !important;
        }

        /* Piccola fine-tuning su mobile vs desktop */
        @media (max-width: 576px) {
            .pagination {
                flex-wrap: nowrap;
            }
        }
    </style>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/js/app.js'])

</head>

<body class="bg-dark text-light d-flex flex-column" data-theme="dark">
    <div id="app">

        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('cocktails.index') }}">
                    <div class="logo_laravel me-2">
                        🍸
                    </div>
                    <span>Cocktail App</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Left Side Navbar --}}
                    <ul class="navbar-nav me-auto">

                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cocktails.index') }}">Manage Cocktails</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('types.index') }}">Manage Types</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ingredients.index') }}">Manage Ingredients</a>
                            </li>
                        @endauth
                    </ul>

                    {{-- Right Side Navbar --}}
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('dashboard') }}">Dashboard</a>
                                    <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li>
                                <button id="theme-toggle" class="btn btn-sm btn-outline-light border-0 ms-2">
                                    🌙
                                </button>
                            </li>
                        @endguest
                    </ul>

                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="flex-grow-1 py-4 min-vh-100">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-dark text-light text-center py-4 mt-auto">
            <div class="container">
                <small>© 2025 Cocktail App - Made with ❤️ by Biagio</small>
            </div>
        </footer>

    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('theme-toggle');
        const body = document.body;

        function applyTheme() {
            const isLight = localStorage.getItem('theme') === 'light';

            // Body
            body.classList.toggle('bg-light', isLight);
            body.classList.toggle('text-dark', isLight);
            body.classList.toggle('bg-dark', !isLight);
            body.classList.toggle('text-light', !isLight);
            toggleButton.innerHTML = isLight ? '🌙' : '☀️';

            // Tables (striped, dark)
            document.querySelectorAll('table.table').forEach(table => {
                table.classList.toggle('table-dark', !isLight);
            });

            // Form controls
            document.querySelectorAll('input.form-control, textarea.form-control, select.form-select').forEach(
                el => {
                    el.classList.toggle('bg-white', isLight);
                    el.classList.toggle('text-dark', isLight);
                    el.classList.toggle('bg-dark', !isLight);
                    el.classList.toggle('text-light', !isLight);
                });

            // Cards
            document.querySelectorAll('.card').forEach(el => {
                el.classList.toggle('bg-white', isLight);
                el.classList.toggle('text-dark', isLight);
                el.classList.toggle('bg-dark', !isLight);
                el.classList.toggle('text-light', !isLight);
            });

            // List group items (Types/Ingredients show)
            document.querySelectorAll('.list-group-item').forEach(el => {
                el.classList.toggle('bg-white', isLight);
                el.classList.toggle('text-dark', isLight);
                el.classList.toggle('bg-dark', !isLight);
                el.classList.toggle('text-light', !isLight);
            });

            // Badges
            document.querySelectorAll('.badge').forEach(el => {
                // mantieni badge-info / badge-secondary ma assicura testo visibile
                el.classList.toggle('text-dark', isLight);
                el.classList.toggle('text-light', !isLight);
            });

            // Pagination container
            document.querySelectorAll('.pagination').forEach(el => {
                el.classList.toggle('pagination-dark', !isLight);
            });

            // Pagination links
            document.querySelectorAll('.pagination .page-link').forEach(el => {
                el.classList.toggle('bg-light', isLight);
                el.classList.toggle('text-dark', isLight);
                el.classList.toggle('bg-dark', !isLight);
                el.classList.toggle('text-light', !isLight);
            });
        }

        // Initialize
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'dark');
        }
        applyTheme();

        // Toggle handler
        toggleButton.addEventListener('click', function(event) {
            event.stopPropagation();
            const newTheme = body.classList.contains('bg-light') ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            applyTheme();
        });
    });
</script>


</html>
