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

            <div class="prototype-shell" data-prototype-shell>
                <div class="feature-panel feature-panel--wide">
                    <div class="app-window-bar" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="feature-header">
                        <span class="feature-pill">⭐ Hibrīda veidotājs</span>
                        <h3>Izvēlies savas spēles iezīmes</h3>
                    </div>
                    <div class="tag-list" data-preferences>
                        <button class="tag-option is-selected" type="button">RPG</button>
                        <button class="tag-option is-selected" type="button">Action</button>
                        <button class="tag-option" type="button">Co-op</button>
                        <button class="tag-option" type="button">Story</button>
                        <button class="tag-option is-selected" type="button">Open World</button>
                        <button class="tag-option" type="button">Indie</button>
                        <button class="tag-option" type="button">Competitive</button>
                        <button class="tag-option" type="button">Relaxed</button>
                    </div>
                    <div class="feature-summary">
                        <strong>Pašlaik atlasīts:</strong>
                        <span data-selected-tags>RPG, Action, Open World</span>
                    </div>
                </div>

                <div class="feature-panel">
                    <div class="app-window-bar" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="feature-header">
                        <span class="feature-pill">↻ Adaptive random</span>
                        <h3>Random ieteikumi</h3>
                    </div>
                    <div class="filter-row">
                        <label>
                            Platforma
                            <select data-random-platform>
                                <option value="PC" selected>PC</option>
                                <option value="Console">Console</option>
                                <option value="Mobile">Mobile</option>
                            </select>
                        </label>
                        <label>
                            Laiks
                            <select data-random-time>
                                <option value="Short">Īss</option>
                                <option value="Medium" selected>Vidējs</option>
                                <option value="Long">Garš</option>
                            </select>
                        </label>
                    </div>
                    <div class="recommendation-list" data-random-list></div>
                </div>

                <div class="feature-panel">
                    <div class="app-window-bar" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="feature-header">
                        <span class="feature-pill">⇄ Salīdzināšana</span>
                        <h3>Divu spēļu salīdzinājums</h3>
                    </div>
                    <div class="comparison-grid" data-comparison></div>
                </div>

                <div class="feature-panel">
                    <div class="app-window-bar" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="feature-header">
                        <span class="feature-pill">%</span>
                        <h3>Atbilstības rādītāji</h3>
                    </div>
                    <div class="score-list" data-score-list></div>
                </div>

                <div class="feature-panel feature-panel--wide">
                    <div class="app-window-bar" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="feature-header">
                        <span class="feature-pill">⚔ Turnīrs</span>
                        <h3>Izvēlies uzvarētāju</h3>
                    </div>
                    <div class="tournament-grid" data-tournament></div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const prototypeGames = [
            { name: 'The Witcher 3', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Story', match: 94, mood: 'epic' },
            { name: 'Counter-Strike 2', genre: 'Action', platform: 'PC', time: 'Short', style: 'Competitive', match: 88, mood: 'fast' },
            { name: 'Stardew Valley', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Relaxed', match: 91, mood: 'cozy' },
            { name: 'Hades', genre: 'Action', platform: 'PC', time: 'Medium', style: 'Competitive', match: 86, mood: 'challenging' },
            { name: 'Portal 2', genre: 'Action', platform: 'PC', time: 'Short', style: 'Co-op', match: 82, mood: 'smart' },
            { name: 'Red Dead Redemption 2', genre: 'Action', platform: 'PC', time: 'Long', style: 'Open World', match: 90, mood: 'immersive' },
            { name: 'Terraria', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Indie', match: 84, mood: 'creative' },
            { name: 'Skyrim', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Open World', match: 93, mood: 'explore' },
        ];

        const tagButtons = [...document.querySelectorAll('[data-preferences] .tag-option')];
        const selectedTags = document.querySelector('[data-selected-tags]');
        const randomList = document.querySelector('[data-random-list]');
        const comparison = document.querySelector('[data-comparison]');
        const scoreList = document.querySelector('[data-score-list]');
        const tournament = document.querySelector('[data-tournament]');
        const randomPlatform = document.querySelector('[data-random-platform]');
        const randomTime = document.querySelector('[data-random-time]');

        const prototypeState = {
            selectedTags: tagButtons
                .filter((button) => button.classList.contains('is-selected'))
                .map((button) => button.textContent.trim())
                .filter(Boolean),
            platform: randomPlatform ? randomPlatform.value : 'PC',
            time: randomTime ? randomTime.value : 'Medium',
            tournamentWinner: null,
        };

        function getFilteredGames() {
            if (!prototypeState.selectedTags.length) {
                return [];
            }

            return prototypeGames.filter((game) => {
                const matchesPlatform = game.platform === prototypeState.platform;
                const matchesTime = prototypeState.time === 'Short'
                    ? game.time === 'Short'
                    : prototypeState.time === 'Long'
                        ? game.time === 'Long' || game.time === 'Medium'
                        : true;

                const hasTagMatch = prototypeState.selectedTags.some((tag) =>
                    [game.genre, game.style, game.mood].includes(tag)
                );

                return matchesPlatform && matchesTime && hasTagMatch;
            });
        }

        function calculateMatch(game) {
            let total = 45;

            prototypeState.selectedTags.forEach((tag) => {
                if ([game.genre, game.style, game.mood].includes(tag)) {
                    total += 12;
                }
            });

            if (game.platform === prototypeState.platform) {
                total += 15;
            }

            if (prototypeState.time === 'Short' && game.time === 'Short') total += 10;
            if (prototypeState.time === 'Medium' && ['Medium', 'Short'].includes(game.time)) total += 8;
            if (prototypeState.time === 'Long' && ['Long', 'Medium'].includes(game.time)) total += 10;

            return Math.min(99, Math.max(65, total));
        }

        function renderSelectedTags() {
            if (selectedTags) {
                selectedTags.textContent = prototypeState.selectedTags.join(', ');
            }
        }

        function renderRandomList() {
            if (!randomList) {
                return;
            }

            const filtered = getFilteredGames();
            const items = filtered.slice(0, 3).map((game) => {
                const match = calculateMatch(game);
                return `
                    <article class="recommendation-card">
                        <div class="recommendation-meta">
                            <strong>${game.name}</strong>
                            <span>${game.genre} · ${game.platform}</span>
                        </div>
                        <div class="score-bar"><span style="width: ${match}%"></span></div>
                        <div class="recommendation-footer">
                            <span>${match}% atbilstība</span>
                            <button type="button" data-game-name="${game.name}">Salīdzināt</button>
                        </div>
                    </article>
                `;
            }).join('');

            randomList.innerHTML = items || '<p class="empty-state">Nav daudz saderīgu spēļu ar šiem kritērijiem.</p>';
        }

        function renderComparison() {
            if (!comparison) {
                return;
            }

            const filtered = getFilteredGames();
            const first = filtered[0] || prototypeGames[0];
            const second = filtered[1] || prototypeGames[1];

            comparison.innerHTML = [first, second].map((game) => {
                const match = calculateMatch(game);
                return `
                    <article class="comparison-card">
                        <h4>${game.name}</h4>
                        <div class="comparison-stat">
                            <span>Žanrs</span>
                            <strong>${game.genre}</strong>
                        </div>
                        <div class="comparison-stat">
                            <span>Platforma</span>
                            <strong>${game.platform}</strong>
                        </div>
                        <div class="comparison-stat">
                            <span>Garums</span>
                            <strong>${game.time}</strong>
                        </div>
                        <div class="comparison-stat">
                            <span>Atbilstība</span>
                            <strong>${match}%</strong>
                        </div>
                    </article>
                `;
            }).join('');
        }

        function renderScores() {
            if (!scoreList) {
                return;
            }

            const filtered = getFilteredGames();
            const top = filtered.slice(0, 4);
            scoreList.innerHTML = top.map((game) => {
                const match = calculateMatch(game);
                return `
                    <div class="score-row">
                        <div>
                            <strong>${game.name}</strong>
                            <span>${game.genre} · ${game.style}</span>
                        </div>
                        <div class="score-line">
                            <span style="width: ${match}%"></span>
                        </div>
                        <em>${match}%</em>
                    </div>
                `;
            }).join('');
        }

        function renderTournament() {
            if (!tournament) {
                return;
            }

            const filtered = getFilteredGames();
            const pool = filtered.slice(0, 4);
            const finalPool = pool.length ? pool : prototypeGames.slice(0, 4);

            tournament.innerHTML = finalPool.map((game) => `
                <button class="tournament-card ${prototypeState.tournamentWinner === game.name ? 'is-selected' : ''}" type="button" data-tournament-choice="${game.name}">
                    <span>${game.name}</span>
                    <small>${game.genre} · ${game.style}</small>
                </button>
            `).join('');

            if (prototypeState.tournamentWinner) {
                tournament.insertAdjacentHTML('beforeend', `
                    <div class="winner-banner">
                        <strong>Labākā izvēle:</strong>
                        <span>${prototypeState.tournamentWinner}</span>
                    </div>
                `);
            }
        }

        tagButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const label = button.textContent.trim();
                const index = prototypeState.selectedTags.indexOf(label);

                if (index >= 0) {
                    prototypeState.selectedTags.splice(index, 1);
                    button.classList.remove('is-selected');
                } else {
                    if (prototypeState.selectedTags.length >= 5) {
                        prototypeState.selectedTags.shift();
                    }
                    prototypeState.selectedTags.push(label);
                    button.classList.add('is-selected');
                }

                renderSelectedTags();
                renderAll();
            });
        });

        if (randomPlatform) {
            randomPlatform.addEventListener('change', (event) => {
                prototypeState.platform = event.target.value;
                renderAll();
            });
        }

        if (randomTime) {
            randomTime.addEventListener('change', (event) => {
                prototypeState.time = event.target.value;
                renderAll();
            });
        }

        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-game-name]');
            const choice = event.target.closest('[data-tournament-choice]');

            if (button) {
                const gameName = button.dataset.gameName;
                const game = prototypeGames.find((entry) => entry.name === gameName) || prototypeGames[0];
                prototypeState.tournamentWinner = game.name;
                renderTournament();
            }

            if (choice) {
                prototypeState.tournamentWinner = choice.dataset.tournamentChoice;
                renderTournament();
            }
        });

        function renderAll() {
            renderSelectedTags();
            renderRandomList();
            renderComparison();
            renderScores();
            renderTournament();
        }

        renderAll();
    </script>
</body>
</html>
