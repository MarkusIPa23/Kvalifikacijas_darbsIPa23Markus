<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Atbilstības rādītāji</title>
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
                <a href="{{ route('future') }}">Nākotne</a>
                <a href="{{ route('home') }}">Sākums</a>
                <a href="{{ route('games.search') }}" class="nav-cta">🎮</a>
            </nav>
        </header>

        <main class="selection-page">
            <a class="back-link" href="{{ route('future') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18 9 12l6-6" /></svg>
                Atpakaļ uz Nākotni
            </a>

            <section class="selection-intro">
                <p class="eyebrow">ATBILSTĪBAS RĀDĪTĀJI</p>
                <h1>Skatiet, cik labi spēle iederas.</h1>
                <p>Rādītāji parāda prioritātes procentuāli, palīdzot salīdzināt ieteiktos varianti.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Atbilstības vērtējums</h2>
                            <p>Vietas pēc procentuālās saderības</p>
                        </div>
                        <span class="filter-count">4 rezultāti</span>
                    </div>

                    <div class="score-list" data-score-list></div>
                </div>

                <aside class="side-tip">
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div class="mini-label">Mērījumi</div>
                    <h2>Procentuāli skaidrs rezultāts</h2>
                    <p>Jo augstāks procents, jo labāk spēle atbilst izvēlētajai gaumei un stilam.</p>
                </aside>
            </div>
        </main>
    </div>

    <script>
        const scoreList = document.querySelector('[data-score-list]');

        const rankedGames = [
            { name: 'The Witcher 3', genre: 'RPG', style: 'Story', score: 72 },
            { name: 'Counter-Strike 2', genre: 'Action', style: 'Competitive', score: 80 },
            { name: 'Stardew Valley', genre: 'RPG', style: 'Relaxed', score: 72 },
            { name: 'Hades', genre: 'Action', style: 'Competitive', score: 80 },
        ];

        scoreList.innerHTML = rankedGames.map((game) => `
            <div class="score-row">
                <div>
                    <strong>${game.name}</strong>
                    <span>${game.genre} · ${game.style}</span>
                </div>
                <div class="score-line"><span style="width: ${game.score}%"></span></div>
                <em>${game.score}%</em>
            </div>
        `).join('');
    </script>
</body>
</html>
