<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Adaptive random</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('future.partials.store-wallpaper')
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

        <main class="selection-page random-selection-page">
            <a class="back-link" href="{{ route('future') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18 9 12l6-6" /></svg>
                Atpakaļ uz Nākotni
            </a>

            <section class="selection-intro">
                <p class="eyebrow">SPĒĻU IZVĒLE / RAWG KATALOGS</p>
                <h1>Ko spēlēsim šovakar?</h1>
                <p>Izvēlies platformu un žanru, atrodi konkrētu spēli vai ļauj katalogam izlemt tavā vietā.</p>
            </section>

            <div class="selection-layout random-selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <p class="random-section-kicker">01 / ATLASE</p>
                            <h2>Noskaņo savu izlasi</h2>
                            <p>Rezultāti tiek atlasīti no RAWG spēļu kataloga.</p>
                        </div>
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
                            <input id="random-game-search" type="search" maxlength="100" placeholder="Piemēram, Hollow Knight" data-random-search aria-label="Meklēt spēli pēc nosaukuma">
                            <button class="button button-secondary" type="submit">Meklēt spēli</button>
                            <button class="future-search-clear" type="button" data-random-search-clear hidden>Notīrīt</button>
                        </div>
                    </form>

                    <div class="random-actions">
                        <button class="button button-secondary" type="button" data-show-all-results disabled>Atiestatīt filtrus</button>
                        <button class="button button-primary random-next-button" type="button" data-next-random disabled>Izvēlies man spēli</button>
                    </div>

                    <section class="random-results" aria-labelledby="random-results-title">
                        <div class="random-results-heading">
                            <div>
                                <p class="random-section-kicker">02 / SPĒLES</p>
                                <h2 id="random-results-title">Atbilst tavai izlasei</h2>
                            </div>
                            <span class="filter-count" data-random-count aria-live="polite">Notiek ielāde</span>
                        </div>
                        <div class="recommendation-list random-results-list" data-random-list aria-busy="true"></div>
                        <p class="hybrid-search-status random-status" data-random-status role="status" aria-live="polite">Notiek spēļu ielāde no kataloga...</p>
                    </section>
                </div>

                <aside class="random-spotlight" aria-label="Izvēlētā spēle">
                    <p class="random-spotlight-kicker">TAVS NĀKAMAIS STARTS</p>
                    <h2>Vēl neesi izlēmis?</h2>
                    <div class="random-picked" data-random-picked aria-live="polite">
                        <div class="random-pick-empty">
                            <span aria-hidden="true">?</span>
                            <p>Izvēlies filtrus un nospied “Izvēlies man spēli”.</p>
                        </div>
                    </div>
                    <div class="random-spotlight-note">
                        <span class="random-live-dot" aria-hidden="true"></span>
                        <p>Vērtējumi no RAWG kopienas</p>
                    </div>
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
            selectedId: null,
        };
        let randomRequestId = 0;
        let randomController = null;

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
            randomList.setAttribute('aria-busy', 'false');
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
                            ${game.thumbnail ? `<a class="recommendation-art" href="${FutureGamesApi.detailUrl(game.id)}" tabindex="-1" aria-hidden="true"><img src="${escapeHtml(game.thumbnail)}" alt="" loading="lazy" decoding="async"></a>` : '<div class="recommendation-art recommendation-art-empty" aria-hidden="true"></div>'}
                            <div class="recommendation-meta">
                                <strong><a href="${FutureGamesApi.detailUrl(game.id)}">${escapeHtml(game.title)}</a></strong>
                                <span>${escapeHtml(game.genre)} · ${escapeHtml(game.platform)}</span>
                            </div>
                            <div class="score-bar" role="img" aria-label="${ratingScore ? `${ratingScore.toFixed(1)} no 5` : 'RAWG vērtējuma nav'}"><span style="width: ${ratingScore * 20}%"></span></div>
                            <div class="recommendation-footer">
                                <span>${ratingScore ? `${ratingScore.toFixed(1)}/5 RAWG vērtējums` : 'RAWG vērtējuma nav'}</span>
                                <button type="button" data-pick-game data-game-id="${escapeHtml(game.id)}" aria-pressed="${String(game.id) === String(randomState.selectedId)}">${String(game.id) === String(randomState.selectedId) ? 'Izvēlēta' : 'Izvēlēties'}</button>
                            </div>
                        </article>
                    `;
                }).join('');
        }

        function showPickedGame(chosen) {
            const rating = chosen.rating === null || chosen.rating === undefined ? NaN : Number(chosen.rating);
            const detailUrl = FutureGamesApi.detailUrl(chosen.id);
            randomState.selectedId = chosen.id;
            randomPicked.innerHTML = `
                ${chosen.thumbnail ? `<img class="random-picked-art" src="${escapeHtml(chosen.thumbnail)}" alt="${escapeHtml(chosen.title)}" loading="lazy" decoding="async">` : '<div class="random-picked-art random-picked-art-empty" aria-hidden="true"></div>'}
                <div class="random-picked-content">
                    <div>
                        <span class="random-picked-badge">IZVĒLĒTĀ SPĒLE</span>
                        <h3>${escapeHtml(chosen.title)}</h3>
                        <p>${escapeHtml(chosen.genre)} · ${escapeHtml(chosen.platform)}</p>
                    </div>
                    <strong>${Number.isFinite(rating) ? `${rating.toFixed(1)}<small>/5</small>` : 'N/A'}</strong>
                </div>
                <a class="random-picked-link" href="${detailUrl}">Apskatīt spēli <span aria-hidden="true">↗</span></a>
                <span class="random-picked-count">${randomState.seenIds.length} ${randomState.seenIds.length === 1 ? 'spēle izvēlēta' : 'spēles izvēlētas'} šajā atlasē</span>
            `;
            randomPicked.classList.remove('is-new');
            window.requestAnimationFrame(() => randomPicked.classList.add('is-new'));
            randomStatus.textContent = `Izvēlēta spēle: ${chosen.title}.`;
            renderRandomList();
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
            showPickedGame(chosen);
        }

        async function loadRandomGames() {
            const requestId = ++randomRequestId;
            if (randomController) {
                randomController.abort();
            }
            randomController = new AbortController();
            randomStatus.textContent = 'Notiek spēļu ielāde no RAWG kataloga...';
            randomList.setAttribute('aria-busy', 'true');
            randomList.innerHTML = '<div class="random-skeleton"></div><div class="random-skeleton"></div><div class="random-skeleton"></div><div class="random-skeleton"></div>';
            randomPicked.innerHTML = '<div class="random-pick-empty"><span aria-hidden="true">?</span><p>Izvēlies spēli no jaunās atlases.</p></div>';
            randomPicked.classList.remove('is-new');
            randomState.games = [];
            randomState.seenIds = [];
            randomState.selectedId = null;
            nextRandomButton.disabled = true;
            showAllResultsButton.disabled = !randomState.platform && !randomState.genre && !randomState.search;
            randomCount.textContent = 'Ielādē';
            const filters = { page_size: 40, ordering: '-rating' };
            if (randomState.platform) filters.platform = randomState.platform;
            if (randomState.genre) filters.genres = [randomState.genre];
            if (randomState.search) filters.search = randomState.search;

            try {
                const games = await FutureGamesApi.list(filters, { signal: randomController.signal });
                if (requestId !== randomRequestId) {
                    return;
                }

                randomState.games = games;
                randomStatus.textContent = randomState.games.length ? '' : 'Katalogā spēles pēc šiem filtriem netika atrastas.';
                if (randomState.search) {
                    randomSearchClear.hidden = false;
                }
                nextRandomButton.disabled = randomState.games.length === 0;
                showAllResultsButton.disabled = !randomState.platform && !randomState.genre && !randomState.search;
                renderRandomList();
            } catch (error) {
                if (requestId !== randomRequestId || error.name === 'AbortError') {
                    return;
                }

                randomState.games = [];
                randomStatus.textContent = error.message;
                renderRandomList('Spēļu katalogu pašlaik nevar ielādēt.');
                randomCount.textContent = 'Kļūda';
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
            if (!(event.target instanceof Element)) {
                return;
            }

            const target = event.target.closest('[data-pick-game]');
            if (!target) {
                return;
            }

            const chosen = randomState.games.find((game) => String(game.id) === target.dataset.gameId);
            if (!chosen) {
                return;
            }

            if (!randomState.seenIds.includes(chosen.id)) {
                randomState.seenIds.push(chosen.id);
            }
            showPickedGame(chosen);
        });

        loadRandomGames();
    </script>
</body>
</html>
