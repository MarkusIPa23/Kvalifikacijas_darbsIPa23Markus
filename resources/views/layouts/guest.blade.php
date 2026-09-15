<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-page">
        <div class="auth-shell">
            <header class="site-header auth-header">
                <a class="brand" href="{{ url('/') }}">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 8h10a4 4 0 0 1 3.8 5.2l-1 3.2a2.5 2.5 0 0 1-4.1 1l-2.1-2.1h-3.2l-2.1 2.1a2.5 2.5 0 0 1-4.1-1l-1-3.2A4 4 0 0 1 7 8Z" />
                            <path d="M8 11v4M6 13h4M16 12h.01M18 14h.01" />
                        </svg>
                    </span>
                    <span>Game to Top</span>
                </a>
                <nav class="site-nav" aria-label="Autentifikācija">
                    <a href="{{ route('games.search') }}">Meklēt spēles</a>
                    @if (request()->routeIs('login'))
                        <a class="nav-cta" href="{{ route('register') }}">Reģistrēties</a>
                    @else
                        <a class="nav-cta" href="{{ route('login') }}">Pieteikties</a>
                    @endif
                </nav>
            </header>

            <main class="auth-content">
                <div class="auth-intro">
                    <p class="eyebrow">GAME TO TOP</p>
                    <h1>{{ request()->routeIs('register') ? 'Izveido savu profilu.' : 'Atgriezies spēlē.' }}</h1>
                    <p>Saglabā savas favorītspēles un atrodi nākamo spēli vienuviet.</p>
                </div>

                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
