<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Adaptive random</title>
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
                <p class="eyebrow">ADAPTIVE RANDOM</p>
                <h1>Random ieteikumi.</h1>
                <p>Izvēlies platformu un laika apjomu, lai atrastu spēles, kas vislabāk atbilst tavai garastāvoklim.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Ieteikumu filtrs</h2>
                            <p>Salīdzini nosacījumus</p>
                        </div>
                        <span class="filter-count" data-random-count>46 spēles</span>
                    </div>

                    <div class="filter-grid">
                        <div class="field">
                            <label for="random-platform">Platforma</label>
                            <select id="random-platform" data-random-platform>
                                <option value="All" selected>Visas</option>
                                <option value="PC">PC</option>
                                <option value="Console">Console</option>
                                <option value="Mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="random-time">Laiks</label>
                            <select id="random-time" data-random-time>
                                <option value="Any" selected>Jebkurš</option>
                                <option value="Short">Īss</option>
                                <option value="Medium">Vidējs</option>
                                <option value="Long">Garš</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom:18px;">
                        <button class="button button-secondary" type="button" data-show-all-results>Izvēlēties visas spēles</button>
                        <button class="button button-primary random-next-button" type="button" data-next-random>Uzdot man citu spēli</button>
                    </div>

                    <div class="random-picked" data-random-picked hidden></div>
                    <div class="recommendation-list" data-random-list></div>
                </div>

                <aside class="side-tip">
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div class="mini-label">Kritēriji</div>
                    <h2>Katrs ieteikums tiek izlīdzināts ar jūsu izvēli</h2>
                    <p>Platformas un laika kritēriji maina prioritātes, lai filtrs vienmēr būtu aktuāls.</p>
                </aside>
            </div>
        </main>
    </div>

    <script>
        const prototypeGames = [
            { name: 'The Witcher 3', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Story', mood: 'epic' },
            { name: 'Counter-Strike 2', genre: 'Action', platform: 'PC', time: 'Short', style: 'Competitive', mood: 'fast' },
            { name: 'Stardew Valley', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Relaxed', mood: 'cozy' },
            { name: 'Hades', genre: 'Action', platform: 'PC', time: 'Medium', style: 'Competitive', mood: 'challenging' },
            { name: 'Portal 2', genre: 'Action', platform: 'PC', time: 'Short', style: 'Co-op', mood: 'smart' },
            { name: 'Red Dead Redemption 2', genre: 'Action', platform: 'PC', time: 'Long', style: 'Open World', mood: 'immersive' },
            { name: 'Terraria', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Indie', mood: 'creative' },
            { name: 'Skyrim', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Open World', mood: 'explore' },
            { name: 'Minecraft', genre: 'RPG', platform: 'Mobile', time: 'Long', style: 'Relaxed', mood: 'creative' },
            { name: 'Fortnite', genre: 'Action', platform: 'Console', time: 'Short', style: 'Competitive', mood: 'fast' },
            { name: 'Elden Ring', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Open World', mood: 'challenging' },
            { name: 'Cyberpunk 2077', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Story', mood: 'immersive' },
            { name: 'Baldur\'s Gate 3', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Story', mood: 'epic' },
            { name: 'Hollow Knight', genre: 'Indie', platform: 'PC', time: 'Medium', style: 'Story', mood: 'explore' },
            { name: 'Dead Cells', genre: 'Action', platform: 'PC', time: 'Short', style: 'Indie', mood: 'fast' },
            { name: 'Risk of Rain 2', genre: 'Action', platform: 'PC', time: 'Medium', style: 'Indie', mood: 'challenging' },
            { name: 'Sea of Thieves', genre: 'Co-op', platform: 'Console', time: 'Long', style: 'Open World', mood: 'relaxed' },
            { name: 'Deep Rock Galactic', genre: 'Co-op', platform: 'PC', time: 'Medium', style: 'Competitive', mood: 'cozy' },
            { name: 'Civilization VI', genre: 'Strategy', platform: 'PC', time: 'Long', style: 'Story', mood: 'epic' },
            { name: 'Slay the Spire', genre: 'Strategy', platform: 'Mobile', time: 'Short', style: 'Indie', mood: 'smart' },
            { name: 'The Sims 4', genre: 'Simulation', platform: 'PC', time: 'Long', style: 'Relaxed', mood: 'cozy' },
            { name: 'Euro Truck Simulator 2', genre: 'Simulation', platform: 'PC', time: 'Long', style: 'Relaxed', mood: 'relaxed' },
            { name: 'Trackmania', genre: 'Racing', platform: 'PC', time: 'Short', style: 'Competitive', mood: 'fast' },
            { name: 'Forza Horizon 5', genre: 'Racing', platform: 'Console', time: 'Medium', style: 'Open World', mood: 'epic' },
            { name: 'Apex Legends', genre: 'Action', platform: 'Console', time: 'Short', style: 'Competitive', mood: 'fast' },
            { name: 'Subnautica', genre: 'Indie', platform: 'PC', time: 'Long', style: 'Open World', mood: 'explore' },
            { name: 'Grand Theft Auto V', genre: 'Action', platform: 'PC', time: 'Long', style: 'Open World', mood: 'fast' },
            { name: 'Fallout 4', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Open World', mood: 'explore' },
            { name: 'Valheim', genre: 'Co-op', platform: 'PC', time: 'Long', style: 'Open World', mood: 'creative' },
            { name: 'Among Us', genre: 'Co-op', platform: 'Mobile', time: 'Short', style: 'Competitive', mood: 'fun' },
            { name: 'It Takes Two', genre: 'Co-op', platform: 'Console', time: 'Medium', style: 'Story', mood: 'cozy' },
            { name: 'Dota 2', genre: 'Action', platform: 'PC', time: 'Medium', style: 'Competitive', mood: 'challenging' },
            { name: 'League of Legends', genre: 'Action', platform: 'PC', time: 'Medium', style: 'Competitive', mood: 'fast' },
            { name: 'Rocket League', genre: 'Racing', platform: 'Console', time: 'Short', style: 'Competitive', mood: 'fast' },
            { name: 'Need for Speed Heat', genre: 'Racing', platform: 'PC', time: 'Medium', style: 'Open World', mood: 'fast' },
            { name: 'Cities: Skylines', genre: 'Simulation', platform: 'PC', time: 'Long', style: 'Relaxed', mood: 'creative' },
            { name: 'Planet Zoo', genre: 'Simulation', platform: 'PC', time: 'Long', style: 'Relaxed', mood: 'cozy' },
            { name: 'Civilization VI', genre: 'Strategy', platform: 'PC', time: 'Long', style: 'Story', mood: 'epic' },
            { name: 'Age of Empires IV', genre: 'Strategy', platform: 'PC', time: 'Medium', style: 'Competitive', mood: 'challenging' },
            { name: 'Slay the Spire', genre: 'Strategy', platform: 'Mobile', time: 'Short', style: 'Indie', mood: 'smart' },
            { name: 'Cuphead', genre: 'Action', platform: 'Console', time: 'Short', style: 'Indie', mood: 'challenging' },
            { name: 'Ori and the Will of the Wisps', genre: 'Indie', platform: 'PC', time: 'Medium', style: 'Story', mood: 'explore' },
            { name: 'Celeste', genre: 'Indie', platform: 'PC', time: 'Short', style: 'Story', mood: 'challenging' },
            { name: 'Outer Wilds', genre: 'Indie', platform: 'PC', time: 'Medium', style: 'Open World', mood: 'explore' },
            { name: 'No Man\'s Sky', genre: 'Indie', platform: 'Console', time: 'Long', style: 'Open World', mood: 'explore' },
            { name: 'Monster Hunter: World', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Co-op', mood: 'challenging' },
        ];

        const randomList = document.querySelector('[data-random-list]');
        const randomPlatform = document.querySelector('[data-random-platform]');
        const randomTime = document.querySelector('[data-random-time]');
        const showAllResultsButton = document.querySelector('[data-show-all-results]');
        const nextRandomButton = document.querySelector('[data-next-random]');
        const randomPicked = document.querySelector('[data-random-picked]');
        const randomCount = document.querySelector('[data-random-count]');

        const prototypeState = {
            platform: randomPlatform ? randomPlatform.value : 'All',
            time: randomTime ? randomTime.value : 'Any',
            seenGames: [],
            showAllResults: true,
        };

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, (character) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;',
            }[character]));
        }

        function calculateMatch(game) {
            let total = 45;

            if (prototypeState.platform !== 'All' && game.platform === prototypeState.platform) total += 20;
            if (prototypeState.platform === 'All') total += 10;

            if (prototypeState.time !== 'Any' && prototypeState.time === 'Short' && game.time === 'Short') total += 18;
            if (prototypeState.time !== 'Any' && prototypeState.time === 'Medium' && ['Medium', 'Short'].includes(game.time)) total += 14;
            if (prototypeState.time !== 'Any' && prototypeState.time === 'Long' && ['Long', 'Medium'].includes(game.time)) total += 16;

            if (prototypeState.time === 'Any') total += 10;
            if (game.genre === 'RPG' && (prototypeState.time === 'Long' || prototypeState.time === 'Any')) total += 8;
            if (game.genre === 'Action' && (prototypeState.time === 'Short' || prototypeState.time === 'Any')) total += 8;

            return Math.min(99, Math.max(65, total));
        }

        function getFilteredGames() {
            return prototypeGames.filter((game) => {
                const matchesPlatform = prototypeState.platform === 'All'
                    ? true
                    : game.platform === prototypeState.platform;

                const matchesTime = prototypeState.time === 'Any'
                    ? true
                    : prototypeState.time === 'Short'
                        ? ['Short', 'Medium'].includes(game.time)
                        : prototypeState.time === 'Long'
                            ? ['Long', 'Medium'].includes(game.time)
                            : true;

                return matchesPlatform && matchesTime;
            });
        }

        function renderRandomList() {
            const filtered = getFilteredGames();
            if (!filtered.length) {
                randomList.innerHTML = '<p class="empty-state">Nav saderīgu rezultātu ar izvēlēto kritēriju.</p>';
                return;
            }

            const sortedGames = filtered
                .slice()
                .sort((a, b) => calculateMatch(b) - calculateMatch(a));
            const visibleGames = prototypeState.showAllResults ? sortedGames : sortedGames.slice(0, 6);
            if (randomCount) {
                randomCount.textContent = `${filtered.length} spēles`;
            }

            randomList.innerHTML = visibleGames
                .map((game) => {
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
        }

        function chooseUniqueGame() {
            const filtered = getFilteredGames();
            const available = filtered.filter((game) => !prototypeState.seenGames.includes(game.name));
            const pool = available.length ? available : filtered;

            if (!pool.length || !randomPicked) {
                return;
            }

            if (!available.length) {
                prototypeState.seenGames = [];
            }

            const chosen = pool[Math.floor(Math.random() * pool.length)];
            prototypeState.seenGames.push(chosen.name);
            randomPicked.hidden = false;
            randomPicked.innerHTML = `
                <div class="random-picked-badge">JAUNS UNIKĀLS IETEIKUMS</div>
                <div class="random-picked-content">
                    <div>
                        <h3>${escapeHtml(chosen.name)}</h3>
                        <p>${escapeHtml(chosen.genre)} · ${escapeHtml(chosen.platform)} · ${escapeHtml(chosen.time)}</p>
                        <span>${prototypeState.seenGames.length} spēles jau izmēģinātas šajā atlasē</span>
                    </div>
                    <strong>${calculateMatch(chosen)}%</strong>
                </div>
            `;
            randomPicked.classList.remove('is-new');
            window.requestAnimationFrame(() => randomPicked.classList.add('is-new'));
            renderRandomList();
        }

        randomPlatform.addEventListener('change', (event) => {
            prototypeState.platform = event.target.value;
            prototypeState.seenGames = [];
            prototypeState.showAllResults = false;
            if (randomPicked) randomPicked.hidden = true;
            renderRandomList();
        });

        randomTime.addEventListener('change', (event) => {
            prototypeState.time = event.target.value;
            prototypeState.seenGames = [];
            prototypeState.showAllResults = false;
            if (randomPicked) randomPicked.hidden = true;
            renderRandomList();
        });

        if (showAllResultsButton) {
            showAllResultsButton.addEventListener('click', () => {
                prototypeState.platform = 'All';
                prototypeState.time = 'Any';
                prototypeState.seenGames = [];
                prototypeState.showAllResults = true;
                if (randomPlatform) randomPlatform.value = 'All';
                if (randomTime) randomTime.value = 'Any';
                renderRandomList();
            });
        }

        if (nextRandomButton) {
            nextRandomButton.addEventListener('click', chooseUniqueGame);
        }

        document.addEventListener('click', (event) => {
            const target = event.target.closest('[data-game-name]');
            if (!target) {
                return;
            }

            const chosen = target.dataset.gameName;
            const gameInfo = document.createElement('div');
            gameInfo.className = 'winner-banner';
            gameInfo.innerHTML = `<strong>Pašreizējais ieteikums:</strong><span>${chosen}</span>`;

            const existing = randomList.querySelector('.winner-banner');
            if (existing) {
                existing.remove();
            }

            randomList.appendChild(gameInfo);
        });

        renderRandomList();
    </script>
</body>
</html>
