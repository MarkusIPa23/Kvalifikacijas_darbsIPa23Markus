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
        @include('future.partials.store-wallpaper')
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
                <div class="future-hero-copy">
                    <p class="eyebrow">GAME TO TOP / SPĒĻU LABORATORIJA</p>
                    <h1>Atrodi savu nākamo spēli.</h1>
                    <p>Izpēti RAWG katalogu, salīdzini favorītus vai ļauj nejaušībai izvēlēties tavā vietā.</p>
                    <div class="future-hero-actions">
                        <a class="button button-primary" href="{{ route('games.search') }}">Atvērt katalogu <span aria-hidden="true">↗</span></a>
                        <a class="future-random-link" href="{{ route('future.random') }}">Izvēlēties nejauši <span aria-hidden="true">↗</span></a>
                    </div>
                </div>

                <a class="future-spotlight" data-featured-game hidden>
                    <img data-featured-image src="" alt="" fetchpriority="high" decoding="async">
                    <span class="future-spotlight-shade" aria-hidden="true"></span>
                    <span class="future-spotlight-label">NO RAWG KATALOGA</span>
                    <span class="future-spotlight-copy">
                        <strong data-featured-title></strong>
                        <span data-featured-meta></span>
                    </span>
                    <span class="future-spotlight-open" aria-hidden="true">↗</span>
                </a>
                <p class="future-spotlight-status" data-featured-status role="status">Ielādē spēles izcēlumu...</p>
            </section>

            <section class="future-section" aria-labelledby="future-features-title">
                <div class="section-heading">
                    <p class="eyebrow">NĀKOTNES FUNKCIJAS</p>
                    <h2 id="future-features-title">Atver kādu no spēļu rīkiem.</h2>
                    <p>Piecas iespējas, viens dzīvs spēļu katalogs.</p>
                </div>

                <div class="future-grid">
                    <a class="future-card" href="{{ route('future.hybrid') }}">
                        <span class="future-icon">⭐</span>
                        <h3>Hibrīda veidotājs</h3>
                        <p>Atlasi spēles pēc RAWG žanriem un veido kombinācijas.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.random') }}">
                        <span class="future-icon">↻</span>
                        <h3>Adaptive random</h3>
                        <p>Filtrē pēc platformas un žanra vai izvēlies nejaušu spēli.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.comparison') }}">
                        <span class="future-icon">⇄</span>
                        <h3>Salīdzināšana</h3>
                        <p>Salīdzini spēļu žanrus, platformas un vērtējumus.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.matches') }}">
                        <span class="future-icon">%</span>
                        <h3>RAWG vērtējumi</h3>
                        <p>Pārlūko kataloga vērtējumus un spēļu informāciju.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                    <a class="future-card" href="{{ route('future.tournament') }}">
                        <span class="future-icon">⚔</span>
                        <h3>Turnīrs</h3>
                        <p>Izvēlies spēles no kataloga un nosaki turnīra uzvarētāju.</p>
                        <span class="future-card-action">Atvērt funkciju <span aria-hidden="true">→</span></span>
                    </a>
                </div>
            </section>
        </main>
    </div>
    @include('future.partials.games-api')
    <script>
        const featuredGame = document.querySelector('[data-featured-game]');
        const featuredImage = document.querySelector('[data-featured-image]');
        const featuredTitle = document.querySelector('[data-featured-title]');
        const featuredMeta = document.querySelector('[data-featured-meta]');
        const featuredStatus = document.querySelector('[data-featured-status]');

        FutureGamesApi.list({ page_size: 12, ordering: '-rating' })
            .then((games) => {
                const game = games.find((item) => item.thumbnail) ?? games[0];

                if (!game) {
                    featuredStatus.textContent = 'Katalogā pašlaik nav pieejamu spēļu.';
                    return;
                }

                featuredImage.src = game.thumbnail ?? '';
                featuredImage.alt = `${game.title} spēles attēls`;
                featuredTitle.textContent = game.title;
                featuredMeta.textContent = `${game.genre} · ${game.platform}${game.rating ? ` · ${Number(game.rating).toFixed(1)}/5` : ''}`;
                featuredGame.href = FutureGamesApi.detailUrl(game.id);
                featuredGame.hidden = false;
                featuredStatus.hidden = true;
            })
            .catch((error) => {
                featuredStatus.textContent = error.message;
            });
    </script>
</body>
</html>
