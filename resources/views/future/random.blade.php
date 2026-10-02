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
                <p>Filtrē RAWG kataloga spēles pēc platformas un žanra vai izvēlies nejaušu rezultātu.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Ieteikumu filtrs</h2>
                            <p>Salīdzini nosacījumus</p>
                        </div>
                        <span class="filter-count" data-random-count>Notiek ielāde</span>
                    </div>

                    <div class="filter-grid">
                        <div class="field">
                            <label for="random-platform">Platforma</label>
                            <select id="random-platform" data-random-platform>
                                <option value="" selected>Visas</option>
                                <option value="pc">PC</option>
                                <option value="playstation">PlayStation</option>
                                <option value="xbox">Xbox</option>
                                <option value="nintendo-switch">Nintendo Switch</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="random-genre">Žanrs</label>
                            <select id="random-genre" data-random-genre>
                                <option value="" selected>Visi žanri</option>
                                <option value="action">Action</option>
                                <option value="adventure">Adventure</option>
                                <option value="indie">Indie</option>
                                <option value="role-playing-games-rpg">RPG</option>
                                <option value="strategy">Strategy</option>
                                <option value="simulation">Simulation</option>
                                <option value="racing">Racing</option>
                            </select>
                        </div>
                    </div>

                    <form class="future-game-search" data-random-search-form>
                        <label for="random-game-search">Meklē spēli pēc nosaukuma</label>
                        <div class="future-game-search-controls">
                            <input id="random-game-search" type="search" maxlength="100" placeholder="Piemēram, Hollow Knight" data-random-search>
                            <button class="button button-secondary" type="submit">Meklēt</button>
                            <button class="future-search-clear" type="button" data-random-search-clear hidden>Notīrīt</button>
                        </div>
                    </form>

                    <div style="margin-bottom:18px;">
                        <button class="button button-secondary" type="button" data-show-all-results>Notīrīt filtrus</button>
                        <button class="button button-primary random-next-button" type="button" data-next-random>Uzdot man citu spēli</button>
                    </div>

                    <div class="random-picked" data-random-picked hidden></div>
                    <div class="recommendation-list" data-random-list></div>
                    <p class="hybrid-search-status" data-random-status role="status">Notiek spēļu ielāde no kataloga...</p>
                </div>

                <aside class="side-tip">
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div class="mini-label">Kritēriji</div>
                    <h2>Reāli kataloga dati</h2>
                    <p>Rezultāti tiek filtrēti RAWG katalogā; vērtējumi ir RAWG kopienas vērtējumi.</p>
                </aside>
            </div>
        </main>
    </div>

    @include('future.partials.games-api')
    <script>
        const randomList = document.querySelector('[data-random-list]');
        const randomPlatform = document.querySelector('[data-random-platform]');
        const randomGenre = document.querySelector('[data-random-genre]');
        const showAllResultsButton = document.querySelector('[data-show-all-results]');
        const nextRandomButton = document.querySelector('[data-next-random]');
        const randomPicked = document.querySelector('[data-random-picked]');
        const randomCount = document.querySelector('[data-random-count]');
        const randomStatus = document.querySelector('[data-random-status]');
        const randomSearchForm = document.querySelector('[data-random-search-form]');
        const randomSearchInput = document.querySelector('[data-random-search]');
        const randomSearchClear = document.querySelector('[data-random-search-clear]');

        const randomState = {
            platform: '',
            genre: '',
            search: '',
            games: [],
            seenIds: [],
        };
        let randomRequestId = 0;

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, (character) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;',
            }[character]));
        }

        function renderRandomList(emptyMessage = 'Nav saderīgu rezultātu ar izvēlēto kritēriju.') {
            if (!randomState.games.length) {
                randomCount.textContent = '0 spēles';
                randomList.innerHTML = `<p class="empty-state">${escapeHtml(emptyMessage)}</p>`;
                return;
            }

            const sortedGames = randomState.games
                .slice()
                .sort((first, second) => (Number(second.rating) || 0) - (Number(first.rating) || 0));
            if (randomCount) {
                randomCount.textContent = `${sortedGames.length} spēles`;
            }

            randomList.innerHTML = sortedGames
                .map((game) => {
                    const rating = Number(game.rating);
                    const ratingScore = Number.isFinite(rating) ? Math.max(0, Math.min(5, rating)) : 0;
                    return `
                        <article class="recommendation-card">
                            ${game.thumbnail ? `<a class="recommendation-art" href="${FutureGamesApi.detailUrl(game.id)}" tabindex="-1" aria-hidden="true"><img src="${escapeHtml(game.thumbnail)}" alt="" loading="lazy" decoding="async"></a>` : ''}
                            <div class="recommendation-meta">
                                <strong><a href="${FutureGamesApi.detailUrl(game.id)}">${escapeHtml(game.title)}</a></strong>
                                <span>${escapeHtml(game.genre)} · ${escapeHtml(game.platform)}</span>
                            </div>
                            <div class="score-bar" role="img" aria-label="${ratingScore ? `${ratingScore.toFixed(1)} no 5` : 'RAWG vērtējuma nav'}"><span style="width: ${ratingScore * 20}%"></span></div>
                            <div class="recommendation-footer">
                                <span>${ratingScore ? `${ratingScore.toFixed(1)}/5 RAWG vērtējums` : 'RAWG vērtējuma nav'}</span>
                                <button type="button" data-game-id="${game.id}">Izvēlēties</button>
                            </div>
                        </article>
                    `;
                }).join('');
        }

        function chooseUniqueGame() {
            const available = randomState.games.filter((game) => !randomState.seenIds.includes(game.id));
            const pool = available.length ? available : randomState.games;

            if (!pool.length || !randomPicked) {
                randomStatus.textContent = 'Nav spēļu, ko izvēlēties.';
                return;
            }

            if (!available.length) {
                randomState.seenIds = [];
            }

            const chosen = pool[Math.floor(Math.random() * pool.length)];
            randomState.seenIds.push(chosen.id);
            const rating = Number(chosen.rating);
            randomPicked.hidden = false;
            randomPicked.innerHTML = `
                <div class="random-picked-badge">NEJAUŠA RAWG KATALOGA SPĒLE</div>
                <div class="random-picked-content">
                    <div>
                        <h3>${escapeHtml(chosen.title)}</h3>
                        <p>${escapeHtml(chosen.genre)} · ${escapeHtml(chosen.platform)}</p>
                        <span>${randomState.seenIds.length} spēles izvēlētas šajā atlasē</span>
                    </div>
                    <strong>${Number.isFinite(rating) ? `${rating.toFixed(1)}/5` : 'N/A'}</strong>
                </div>
            `;
            randomPicked.classList.remove('is-new');
            window.requestAnimationFrame(() => randomPicked.classList.add('is-new'));
            renderRandomList();
        }

        async function loadRandomGames() {
            const requestId = ++randomRequestId;
            randomStatus.textContent = 'Notiek spēļu ielāde no RAWG kataloga...';
            randomList.innerHTML = '';
            randomPicked.hidden = true;
            randomState.games = [];
            randomState.seenIds = [];
            nextRandomButton.disabled = true;
            randomCount.textContent = 'Notiek ielāde';
            const filters = { page_size: 40, ordering: '-rating' };
            if (randomState.platform) filters.platform = randomState.platform;
            if (randomState.genre) filters.genres = [randomState.genre];
            if (randomState.search) filters.search = randomState.search;

            try {
                const games = await FutureGamesApi.list(filters);
                if (requestId !== randomRequestId) {
                    return;
                }

                randomState.games = games;
                randomStatus.textContent = randomState.games.length ? '' : 'Katalogā spēles pēc šiem filtriem netika atrastas.';
                if (randomState.search) {
                    randomSearchClear.hidden = false;
                }
                nextRandomButton.disabled = randomState.games.length === 0;
                renderRandomList();
            } catch (error) {
                if (requestId !== randomRequestId || error.name === 'AbortError') {
                    return;
                }

                randomState.games = [];
                randomStatus.textContent = error.message;
                renderRandomList('Spēļu katalogu pašlaik nevar ielādēt.');
                randomCount.textContent = 'Nav pieejams';
            }
        }

        randomPlatform.addEventListener('change', (event) => {
            randomState.platform = event.target.value;
            loadRandomGames();
        });

        randomGenre.addEventListener('change', (event) => {
            randomState.genre = event.target.value;
            loadRandomGames();
        });

        randomSearchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            randomState.search = randomSearchInput.value.trim();
            randomSearchClear.hidden = !randomState.search;
            loadRandomGames();
        });

        randomSearchClear.addEventListener('click', () => {
            randomSearchInput.value = '';
            randomState.search = '';
            randomSearchClear.hidden = true;
            loadRandomGames();
            randomSearchInput.focus();
        });

        if (showAllResultsButton) {
            showAllResultsButton.addEventListener('click', () => {
                randomState.platform = '';
                randomState.genre = '';
                randomState.search = '';
                randomPlatform.value = '';
                randomGenre.value = '';
                randomSearchInput.value = '';
                randomSearchClear.hidden = true;
                loadRandomGames();
            });
        }

        if (nextRandomButton) {
            nextRandomButton.addEventListener('click', chooseUniqueGame);
        }

        document.addEventListener('click', (event) => {
            const target = event.target.closest('[data-game-id]');
            if (!target) {
                return;
            }

            const chosen = randomState.games.find((game) => String(game.id) === target.dataset.gameId);
            if (!chosen) return;
            const gameInfo = document.createElement('div');
            gameInfo.className = 'winner-banner';
            const label = document.createElement('strong');
            label.textContent = 'Izvēlētā spēle:';
            const title = document.createElement('span');
            title.textContent = chosen.title;
            gameInfo.append(label, title);

            const existing = randomList.querySelector('.winner-banner');
            if (existing) {
                existing.remove();
            }

            randomList.appendChild(gameInfo);
        });

        loadRandomGames();
    </script>
</body>
</html>
