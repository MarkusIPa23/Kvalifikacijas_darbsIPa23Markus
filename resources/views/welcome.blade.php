<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top</title>
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
                @auth
                    <a href="{{ route('dashboard') }}">Mans profils</a>
                @else
                    <a href="{{ route('login') }}">Pieteikties</a>
                    <a class="nav-cta" href="{{ route('register') }}">Reģistrēties</a>
                @endauth
                <a class="nav-cta" href="{{ route('games.search') }}">🎮</a>
            </nav>
        </header>

        <main>
            <section class="hero">
                <div>
                    <h1>Atrodi sev <span>spēli.</span></h1>
                    <div class="button-row">
                        <a class="button button-primary" href="{{ route('games.search') }}">
                            Meklēt spēles
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 14 0M13 6l6 6-6 6" /></svg>
                        </a>
                        <a class="button button-secondary" href="{{ route('games.random') }}">Random spēle</a>
                    </div>
                    <p class="hero-note">MB tu atradīsi kk intresantu?</p>
                </div>

                <div class="game-stack" aria-label="Spēles ieteikuma priekšskatījums">
                    <div class="stack-chip chip-one">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 3 1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3Z" /></svg>
                        <span><strong>TOP 10</strong>Populārākās spēles</span>
                    </div>
                    <div class="game-carousel" data-game-carousel>
                        @php
                            $featuredGames = [
                                ['title' => 'Counter-Strike 2', 'app' => '730', 'description' => 'Ātra un konkurētspējīga komandu šaušanas spēle.', 'tags' => ['PC', 'Shooter', 'Online']],
                                ['title' => 'Grand Theft Auto V', 'app' => '271590', 'description' => 'Plaša atvērtā pasaule, stāsts un neaizmirstami piedzīvojumi.', 'tags' => ['PC', 'Action', 'Open world']],
                                ['title' => 'The Witcher 3', 'app' => '292030', 'description' => 'Leģendārs RPG ar lielu pasauli un spēcīgu stāstu.', 'tags' => ['PC', 'RPG', 'Adventure']],
                                ['title' => 'Skyrim', 'app' => '489830', 'description' => 'Izpēti ziemeļu zemi un kļūsti par leģendāru varoni.', 'tags' => ['PC', 'RPG', 'Fantasy']],
                                ['title' => 'Red Dead Redemption 2', 'app' => '1174180', 'description' => 'Plašs vesterns ar detalizētu pasauli un stāstu.', 'tags' => ['PC', 'Action', 'Open world']],
                                ['title' => 'Terraria', 'app' => '105600', 'description' => 'Radi, būvē un pēti neierobežotu pikseļu pasauli.', 'tags' => ['PC', 'Sandbox', 'Indie']],
                                ['title' => 'Portal 2', 'app' => '620', 'description' => 'Gudras mīklas ar humoru, portāliem un lielisku kampaņu.', 'tags' => ['PC', 'Mīklas', 'Co-op']],
                                ['title' => 'Stardew Valley', 'app' => '413150', 'description' => 'Mierīgs piedzīvojums, kurā vari būvēt savu saimniecību.', 'tags' => ['PC', 'RPG', 'Indie']],
                                ['title' => 'Hades', 'app' => '1145360', 'description' => 'Ātra roguelike cīņa, skaists stāsts un katrs mēģinājums citāds.', 'tags' => ['PC', 'Action', 'Roguelike']],
                                ['title' => 'Hollow Knight', 'app' => '367520', 'description' => 'Atmosfēriska izpēte noslēpumainā pazemes valstībā.', 'tags' => ['PC', 'Metroidvania', 'Indie']],
                            ];
                        @endphp
                        @foreach ($featuredGames as $index => $featuredGame)
                            <article class="game-card game-slide{{ $index === 0 ? ' is-active' : '' }}" aria-label="{{ $featuredGame['title'] }}">
                                <img class="game-slide-image" src="https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/{{ $featuredGame['app'] }}/header.jpg" alt="{{ $featuredGame['title'] }} spēles attēls">
                                <div class="game-slide-overlay"></div>
                                <div class="game-slide-content">
                                    <div class="game-card-top"><span>GAME TO TOP / {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span><span class="badge">TOP 10</span></div>
                                    <h2>{{ $featuredGame['title'] }}</h2>
                                    <p>{{ $featuredGame['description'] }}</p>
                                    <div class="game-meta">
                                        @foreach ($featuredGame['tags'] as $tag)
                                            <span>{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="stack-chip chip-two">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 7 9 18l-5-5" /></svg>
                        <span><strong>VIENKĀRŠI</strong>Izvēlies un spēlē</span>
                    </div>
                </div>
            </section>

            <section class="favorites-section" id="favoriti" aria-labelledby="favorites-title">
                <div class="section-heading">
                    <p class="eyebrow">Mani FAviņi</p>
                    <h2 id="favorites-title">Favorītu spēles.</h2>
                    <p>Šeit glabājas spēles, kuras esi atzīmējis kā savas favorītes.</p>
                </div>
                @if (count($favoriteGames) > 0)
                    <div class="favorite-grid">
                        @foreach ($favoriteGames as $favoriteGame)
                            <article class="favorite-card">
                                @if (filled($favoriteGame['thumbnail']))
                                    <img src="{{ $favoriteGame['thumbnail'] }}" alt="{{ $favoriteGame['title'] }} spēles attēls">
                                @endif
                                <div class="favorite-card-info">
                                    <h3>{{ $favoriteGame['title'] }}</h3>
                                    <p class="favorite-card-description">{{ $favoriteGame['description'] ?? 'Apraksts nav pieejams.' }}</p>
                                    <p class="favorite-card-meta">{{ $favoriteGame['genre'] }} · {{ $favoriteGame['releaseDate'] }}</p>
                                    <div class="favorite-card-actions">
                                        <a href="{{ $favoriteGame['url'] }}" target="_blank" rel="noopener noreferrer">Apskatīt spēli</a>
                                        <form action="{{ route('favorites.toggle') }}" method="POST">
                                            @csrf
                                            @foreach ($favoriteGame as $field => $value)
                                                @if (is_scalar($value))
                                                    <input type="hidden" name="{{ $field }}" value="{{ $value }}">
                                                @endif
                                            @endforeach
                                            <button type="submit">Noņemt</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="favorites-empty">
                        <p>Te vēl nav nevienas favorītu spēles.</p>
                        <a class="button button-secondary" href="{{ route('games.search') }}">Meklēt spēles</a>
                    </div>
                @endif
            </section>

            <section class="future-section" aria-labelledby="future-title">
                <div class="section-heading">
                    <p class="eyebrow">NĀKOTNĒ</p>
                    <h2 id="future-title">Tas viss nakotne!</h2>
                </div>
                <div class="future-grid">
                    <article class="future-card">
                        <span class="future-icon" aria-hidden="true">⭐</span>
                        <h3>Spēļu hibrīda veidotājs</h3>
                        <p>Lietotājs izvēlas 2–5 spēles, un sistēma apvieno to žanrus, spēles tipu, platformas, mehānikas un citas īpašības vienā hibrīda spēles konceptā.</p>
                    </article>
                    <article class="future-card">
                        <span class="future-icon" aria-hidden="true">↻</span>
                        <h3>Pielāgojams Random</h3>
                        <p>Lietotājs izvēlas žanru, platformu un izdošanas periodu, un sistēma nejauši izvēlas spēli, kas atbilst kritērijiem.</p>
                    </article>
                    <article class="future-card">
                        <span class="future-icon" aria-hidden="true">⇄</span>
                        <h3>Spēļu salīdzināšana</h3>
                        <p>Lietotājs izvēlas 2–3 spēles, un sistēma tās salīdzina pēc žanra, platformas, izdošanas gada, vērtējuma un citām īpašībām.</p>
                    </article>
                    <article class="future-card">
                        <span class="future-icon" aria-hidden="true">%</span>
                        <h3>Spēles atbilstības procenti</h3>
                        <p>Lietotājs izvēlas savas preferences, un sistēma katrai spēlei aprēķina atbilstību, piemēram, 85%, balstoties uz kritērijiem.</p>
                    </article>
                    <article class="future-card">
                        <span class="future-icon" aria-hidden="true">⚔</span>
                        <h3>Spēļu izvēles turnīrs</h3>
                        <p>Sistēma parāda divas spēles, lietotājs izvēlas vienu, un pēc vairākām kārtām tiek atrasta labākā izvēle.</p>
                    </article>
                </div>
            </section>
        </main>
    </div>
    <script>
        const carousel = document.querySelector('[data-game-carousel]');
        const slides = carousel ? [...carousel.querySelectorAll('.game-slide')] : [];

        if (slides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            let activeSlide = 0;

            window.setInterval(() => {
                slides[activeSlide].classList.remove('is-active');
                activeSlide = (activeSlide + 1) % slides.length;
                slides[activeSlide].classList.add('is-active');
            }, 4500);
        }
    </script>
</body>
