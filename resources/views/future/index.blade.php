<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Nākotne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 8h10a4 4 0 0 1 3.8 5.2l-1 3.2a2.5 2.5 0 0 1-4.1 1l-2.1-2.1h-3.2l-2.1 2.1a2.5 2.5 0 0 1-4.1-1l-1-3.2A4 4 0 0 1 7 8Z" />
                        <path d="M8 11v4M6 13h4M16 12h.01M18 14h.01" />
                    </svg>
                </span>
                <span>Game to Top</span>
            </a>
            <nav class="site-nav" aria-label="Galvenā navigācija">
                <a href="{{ route('home') }}">Sākums</a>
                <a href="{{ route('games.search') }}" class="nav-cta">🎮</a>
            </nav>
        </header>

        <main class="future-page-shell">
            <section class="future-hero">
                <p class="eyebrow">NĀKOTNĒ</p>
                <h1>Viss darbojas kā viens adaptīvs spēļu izvēles mehānisms.</h1>
                <p>Hibrīda veidotājs, pielāgojams random, salīdzināšana un turnīrs veido vienotu sistēmu, kas atlasās spēles pēc tavām vēlmēm, gaumes un spēles stila.</p>
            </section>

            <section class="future-section" aria-labelledby="future-features-title">
                <div class="section-heading">
                    <p class="eyebrow">NĀKOTNES FUNKCIJAS</p>
                    <h2 id="future-features-title">Pārej uz katru jauno moduļu.</h2>
                    <p>Katrs jaunais prototips ir atdalīts savā lapā, lai to būtu viegli pārbaudīt un turpināt pilnveidot.</p>
                </div>

                <div class="future-grid">
                    <a class="future-card" href="{{ route('future.hybrid') }}">
                        <span class="future-icon">⭐</span>
                        <h3>Hibrīda veidotājs</h3>
                        <p>Atlasiet spēļu iezīmes un iegūstiet personalizētu atlasi.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.random') }}">
                        <span class="future-icon">↻</span>
                        <h3>Adaptive random</h3>
                        <p>Izvēlieties platformu un laiku, lai saņemtu ieteikumus.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.comparison') }}">
                        <span class="future-icon">⇄</span>
                        <h3>Salīdzināšana</h3>
                        <p>Salīdziniet divas spēles un izvērtējiet to atbilstību.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.matches') }}">
                        <span class="future-icon">%</span>
                        <h3>Atbilstības rādītāji</h3>
                        <p>Skatiet procentuālās saderības un prioritātes.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.tournament') }}">
                        <span class="future-icon">⚔</span>
                        <h3>Turnīrs</h3>
                        <p>Izvēlieties gada labāko variantu un nosakiet uzvarētāju.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
