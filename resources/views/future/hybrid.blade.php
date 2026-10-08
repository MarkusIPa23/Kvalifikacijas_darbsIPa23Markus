<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Hibrīda veidotājs</title>
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

        <main class="selection-page">
            <a class="back-link" href="{{ route('future') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18 9 12l6-6" /></svg>
                Atpakaļ uz Nākotni
            </a>

            <section class="selection-intro">
                <p class="eyebrow">HIBRĪDA VEIDOTĀJS</p>
                <h1>Izvēlies savas spēles iezīmes.</h1>
                <p>Atlasi spēles pēc RAWG žanriem un veido kombināciju no izvēlētajiem kataloga ierakstiem.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Spēļu preferenču atlase</h2>
                            <p>Izvēlies savas iecienītākās iezīmes</p>
                        </div>
                        <span class="filter-count">Līdz 5</span>
                    </div>

                    <div class="filter-grid">
                        <div class="field" style="grid-column: 1 / -1;">
                            <label>Izvēles</label>
                            <div class="tag-list" data-preferences>
                                <button class="tag-option is-selected" type="button" data-genre="action">Action</button>
                                <button class="tag-option" type="button" data-genre="adventure">Adventure</button>
                                <button class="tag-option" type="button" data-genre="arcade">Arcade</button>
                                <button class="tag-option" type="button" data-genre="fighting">Fighting</button>
                                <button class="tag-option is-selected" type="button" data-genre="indie">Indie</button>
                                <button class="tag-option" type="button" data-genre="platformer">Platformer</button>
                                <button class="tag-option" type="button" data-genre="puzzle">Puzzle</button>
                                <button class="tag-option" type="button" data-genre="racing">Racing</button>
                                <button class="tag-option is-selected" type="button" data-genre="role-playing-games-rpg">RPG</button>
                                <button class="tag-option" type="button" data-genre="shooter">Shooter</button>
                                <button class="tag-option" type="button" data-genre="simulation">Simulation</button>
                                <button class="tag-option" type="button" data-genre="sports">Sports</button>
                                <button class="tag-option" type="button" data-genre="strategy">Strategy</button>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px;">
                        <button class="button button-secondary" type="button" data-select-all-tags>Izlozēt 5 žanrus</button>
                        <button class="button button-secondary" type="button" data-clear-tags>Notīrīt atlasi</button>
                    </div>

                    <div class="feature-summary">
                        <strong>Pašlaik atlasīts:</strong>
                        <span data-selected-tags>Action, Indie, RPG</span>
                    </div>
                    <form class="future-game-search" data-hybrid-search-form>
                        <label for="hybrid-game-search">Meklē konkrētu spēli</label>
                        <div class="future-game-search-controls">
                            <input id="hybrid-game-search" type="search" maxlength="100" placeholder="Piemēram, Hades" data-hybrid-search>
                            <button class="button button-secondary" type="submit">Meklēt</button>
                            <button class="future-search-clear" type="button" data-hybrid-search-clear hidden>Notīrīt</button>
                        </div>
                    </form>
                    <button class="button button-primary hybrid-search-button" type="button" data-find-games>
                        Meklēt spēles pēc žanriem
                    </button>
                    <button class="button button-secondary hybrid-all-games-button" type="button" data-show-all-games>
                        Rādīt visas spēles
                    </button>
                    <p class="hybrid-search-status" data-search-status role="status">Notiek spēļu ielāde no kataloga...</p>
                    <div class="hybrid-combine-bar" data-combine-bar hidden>
                        <span data-combine-count>0 spēles izvēlētas</span>
                        <button class="button button-primary" type="button" data-combine-games>Apvienot spēles</button>
                    </div>
                    <div class="hybrid-results" data-hybrid-results></div>
                    <div class="hybrid-combined-result" data-combined-result hidden></div>
                </div>

                <aside class="side-tip">
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div class="mini-label">Piezīme</div>
                    <h2>Izvēle tiek pielāgota jūsu gaumei</h2>
                    <p>Katra jauna iezīme maina rezultātu, līdz ar to jaunā atlase kļūst pakāpeniski precīzāka.</p>
                </aside>
            </div>
        </main>
    </div>

    @include('future.partials.games-api')
    <script>
        const tagButtons = [...document.querySelectorAll('[data-preferences] .tag-option')];
        const selectedTags = document.querySelector('[data-selected-tags]');
        const selectAllButton = document.querySelector('[data-select-all-tags]');
        const clearTagsButton = document.querySelector('[data-clear-tags]');
        const findGamesButton = document.querySelector('[data-find-games]');
        const showAllGamesButton = document.querySelector('[data-show-all-games]');
        const hybridSearchForm = document.querySelector('[data-hybrid-search-form]');
        const hybridSearchInput = document.querySelector('[data-hybrid-search]');
        const hybridSearchClear = document.querySelector('[data-hybrid-search-clear]');
        const searchStatus = document.querySelector('[data-search-status]');
        const hybridResults = document.querySelector('[data-hybrid-results]');
        const combineBar = document.querySelector('[data-combine-bar]');
        const combineCount = document.querySelector('[data-combine-count]');
        const combineGamesButton = document.querySelector('[data-combine-games]');
        const combinedResult = document.querySelector('[data-combined-result]');

        let hybridGames = [];
        let hybridRequestId = 0;

        const prototypeState = {
            selectedTags: tagButtons
                .filter((button) => button.classList.contains('is-selected'))
                .map((button) => button.dataset.genre),
            showAllGames: false,
            selectedGames: [],
            selectedGameRecords: new Map(),
        };

        function syncTagSelection() {
            tagButtons.forEach((button) => {
                const label = button.dataset.genre;
                button.classList.toggle('is-selected', prototypeState.selectedTags.includes(label));
            });
        }

        function renderSelectedTags() {
            if (selectedTags) {
                selectedTags.textContent = prototypeState.selectedTags
                    .map((genre) => tagButtons.find((button) => button.dataset.genre === genre)?.textContent.trim())
                    .filter(Boolean)
                    .join(', ') || 'Nav atlasītu žanru';
            }
        }

        function pickRandomGenres(count) {
            const genres = tagButtons.map((button) => button.dataset.genre);

            for (let index = genres.length - 1; index > 0; index -= 1) {
                const swapIndex = Math.floor(Math.random() * (index + 1));
                [genres[index], genres[swapIndex]] = [genres[swapIndex], genres[index]];
            }

            return genres.slice(0, count);
        }

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, (character) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;',
            }[character]));
        }

        function renderHybridResults() {
            const requestId = ++hybridRequestId;
            const titleQuery = hybridSearchInput.value.trim();

            if (!hybridResults || !searchStatus) {
                return;
            }

            if (!prototypeState.selectedTags.length && !prototypeState.showAllGames && !titleQuery) {
                searchStatus.textContent = 'Izvēlies žanrus vai meklē spēli pēc nosaukuma.';
                hybridGames = [];
                hybridResults.innerHTML = '';
                renderCombineBar();
                return;
            }

            const filters = { page_size: 40, ordering: '-rating' };
            if (titleQuery) {
                filters.search = titleQuery;
            } else if (!prototypeState.showAllGames) {
                if (prototypeState.selectedTags.length) {
                    filters.genres = prototypeState.selectedTags;
                }
            }
            hybridSearchClear.hidden = !titleQuery;
            searchStatus.textContent = titleQuery
                ? `Meklē “${titleQuery}” RAWG katalogā...`
                : 'Notiek spēļu ielāde no RAWG kataloga...';
            hybridResults.innerHTML = '';
            FutureGamesApi.list(filters).then((results) => {
                if (requestId !== hybridRequestId) {
                    return;
                }

                const selectedIds = new Set(prototypeState.selectedGames);
                const selectedGames = [...prototypeState.selectedGameRecords.values()];
                hybridGames = [
                    ...selectedGames,
                    ...results.filter((game) => !selectedIds.has(game.id)),
                ];
                searchStatus.textContent = results.length
                    ? `Atrastas ${results.length} spēles${titleQuery ? ` pēc nosaukuma “${titleQuery}”` : ' no RAWG kataloga'}.`
                    : 'RAWG katalogā spēles pēc šīs atlases netika atrastas.';
                showAllGamesButton.textContent = prototypeState.showAllGames ? 'Rādīt atlasītos žanrus' : 'Rādīt visas spēles';
                renderHybridCards();
            }).catch((error) => {
                if (requestId !== hybridRequestId || error.name === 'AbortError') {
                    return;
                }

                hybridGames = [];
                searchStatus.textContent = error.message;
                renderHybridCards();
            });
        }

        function renderHybridCards() {
            const selectedIds = new Set(prototypeState.selectedGames);
            const visibleGames = [
                ...prototypeState.selectedGameRecords.values(),
                ...hybridGames.filter((game) => !selectedIds.has(game.id)),
            ];

            hybridResults.innerHTML = visibleGames.length
                ? visibleGames.map((game) => `
                    <article class="hybrid-result-card ${prototypeState.selectedGames.includes(game.id) ? 'is-chosen' : ''}">
                        ${game.thumbnail ? `<img src="${escapeHtml(game.thumbnail)}" alt="${escapeHtml(game.title)} spēles attēls" loading="lazy" decoding="async">` : ''}
                        <div class="hybrid-result-info">
                            <strong><a href="${FutureGamesApi.detailUrl(game.id)}">${escapeHtml(game.title)}</a></strong>
                            <span>${escapeHtml(game.genre)} · ${escapeHtml(game.platform)}</span>
                        </div>
                        <button class="button button-secondary ${prototypeState.selectedGames.includes(game.id) ? 'is-selected' : ''}" type="button" data-select-game="${game.id}">
                            ${prototypeState.selectedGames.includes(game.id) ? 'Izvēlēta' : 'Izvēlēties'}
                        </button>
                    </article>
                `).join('')
                    : '<p class="empty-state">Šiem žanriem pagaidām nav atbilstošu spēļu.</p>';
            renderCombineBar();
        }

        function renderCombineBar() {
            if (!combineBar || !combineCount) {
                return;
            }

            combineBar.hidden = prototypeState.selectedGames.length < 2;
            combineCount.textContent = `${prototypeState.selectedGames.length} spēles izvēlētas`;
        }

        function createUniqueHybridName(genres) {
            const firstWords = ['Neon', 'Astral', 'Crimson', 'Echo', 'Mythic', 'Stellar', 'Wild', 'Infinite'];
            const secondWords = ['Frontier', 'Odyssey', 'Chronicles', 'Nexus', 'Horizon', 'Expedition', 'Legends', 'Protocol'];
            const seed = genres.join('').length + prototypeState.selectedGames.join('').length + Date.now();
            const firstWord = firstWords[seed % firstWords.length];
            const secondWord = secondWords[Math.floor(seed / 7) % secondWords.length];
            return `${firstWord} ${secondWord}`;
        }

        function findSimilarGame(selectedGames) {
            const selectedIds = selectedGames.map((game) => game.id);
            const selectedGenres = [...new Set(selectedGames.flatMap((game) => game.genres))];

            return hybridGames
                .filter((game) => !selectedIds.includes(game.id))
                .map((game) => ({
                    game,
                    score: game.genres.filter((genre) => selectedGenres.includes(genre)).length,
                }))
                .filter((match) => match.score > 0)
                .sort((first, second) => second.score - first.score)[0]?.game;
        }

        tagButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const label = button.dataset.genre;
                const index = prototypeState.selectedTags.indexOf(label);

                if (index >= 0) {
                    prototypeState.selectedTags.splice(index, 1);
                    prototypeState.showAllGames = false;
                } else {
                    if (prototypeState.selectedTags.length >= 5) {
                        searchStatus.textContent = 'Vienlaikus vari atlasīt ne vairāk kā 5 žanrus.';
                        return;
                    }
                    prototypeState.selectedTags.push(label);
                }

                hybridRequestId += 1;
                combinedResult.hidden = true;
                searchStatus.textContent = 'Atlase mainīta. Nospied meklēšanas pogu.';
                showAllGamesButton.textContent = 'Rādīt visas spēles';
                renderCombineBar();
                syncTagSelection();
                renderSelectedTags();
            });
        });

        if (selectAllButton) {
            selectAllButton.addEventListener('click', () => {
                prototypeState.selectedTags = pickRandomGenres(5);
                prototypeState.showAllGames = false;
                hybridRequestId += 1;
                combinedResult.hidden = true;
                searchStatus.textContent = 'Izlozēti 5 nejauši žanri. Nospied meklēšanas pogu, lai atrastu spēles.';
                showAllGamesButton.textContent = 'Rādīt visas spēles';
                renderCombineBar();
                syncTagSelection();
                renderSelectedTags();
            });
        }

        if (clearTagsButton) {
            clearTagsButton.addEventListener('click', () => {
                prototypeState.selectedTags = [];
                prototypeState.showAllGames = false;
                hybridRequestId += 1;
                combinedResult.hidden = true;
                searchStatus.textContent = 'Izvēlies žanrus un nospied meklēšanas pogu.';
                showAllGamesButton.textContent = 'Rādīt visas spēles';
                renderCombineBar();
                syncTagSelection();
                renderSelectedTags();
            });
        }

        if (findGamesButton) {
            findGamesButton.addEventListener('click', renderHybridResults);
        }

        hybridSearchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            renderHybridResults();
        });

        hybridSearchClear.addEventListener('click', () => {
            hybridSearchInput.value = '';
            hybridSearchClear.hidden = true;
            renderHybridResults();
        });

        if (showAllGamesButton) {
            showAllGamesButton.addEventListener('click', () => {
                prototypeState.showAllGames = !prototypeState.showAllGames;
                combinedResult.hidden = true;
                renderHybridResults();
            });
        }

        if (hybridResults) {
            hybridResults.addEventListener('click', (event) => {
                const button = event.target.closest('[data-select-game]');
                if (!button) {
                    return;
                }

                const gameId = Number(button.dataset.selectGame);
                const selectedIndex = prototypeState.selectedGames.indexOf(gameId);
                if (selectedIndex >= 0) {
                    prototypeState.selectedGames.splice(selectedIndex, 1);
                    prototypeState.selectedGameRecords.delete(gameId);
                } else {
                    prototypeState.selectedGames.push(gameId);
                    const selectedGame = hybridGames.find((game) => game.id === gameId);
                    if (selectedGame) {
                        prototypeState.selectedGameRecords.set(gameId, selectedGame);
                    }
                }

                searchStatus.textContent = `${prototypeState.selectedGames.length} spēles izvēlētas apvienošanai.`;
                renderHybridCards();
            });
        }

        if (combineGamesButton) {
            combineGamesButton.addEventListener('click', () => {
                const selected = [...prototypeState.selectedGameRecords.values()];
                if (selected.length < 2 || !combinedResult) {
                    return;
                }

                const genreList = [...new Set(selected.flatMap((game) => game.genres))];
                const genres = genreList.join(' + ');
                const gameNames = selected.map((game) => game.title).join(' × ');
                const hybridName = `${genres}: ${createUniqueHybridName(genreList)}`;
                const sourceCount = selected.length;
                const similarGame = findSimilarGame(selected);
                combinedResult.hidden = false;
                combinedResult.innerHTML = `
                    <div class="hybrid-combined-heading"><span class="mini-label">JAUNA UNIKĀLA SPĒLE</span><strong>${sourceCount} spēļu kombinācija</strong></div>
                    <div class="hybrid-combined-games">${selected.filter((game) => game.thumbnail).map((game) => `<img src="${escapeHtml(game.thumbnail)}" alt="${escapeHtml(game.title)}" loading="lazy" decoding="async">`).join('')}</div>
                    <h3>${escapeHtml(hybridName)}</h3>
                    <p class="hybrid-combined-description">Unikāla spēles ideja, kas apvieno ${escapeHtml(gameNames)} labākās īpašības vienā pasaulē.</p>
                    <div class="hybrid-combined-section"><strong>Precīzie apvienotie žanri</strong><div class="hybrid-combined-tags">${genreList.map((genre) => `<span>${escapeHtml(genre)}</span>`).join('')}</div></div>
                    ${similarGame ? `
                        <div class="hybrid-similar-result">
                            <div class="hybrid-similar-label">LĪDZĪGA SPĒLE PĒC ŽANRIEM</div>
                            ${similarGame.thumbnail ? `<img src="${escapeHtml(similarGame.thumbnail)}" alt="${escapeHtml(similarGame.title)} spēles attēls" loading="lazy" decoding="async">` : ''}
                            <div><strong>${escapeHtml(similarGame.title)}</strong><span>${escapeHtml(similarGame.genre)} · ${escapeHtml(similarGame.platform)}</span></div>
                        </div>
                    ` : ''}
                    <button class="button button-secondary" type="button" data-clear-combination>Sākt jaunu kombināciju</button>
                `;
                combinedResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        }

        if (combinedResult) {
            combinedResult.addEventListener('click', (event) => {
                if (!event.target.closest('[data-clear-combination]')) {
                    return;
                }

                prototypeState.selectedGames = [];
                prototypeState.selectedGameRecords.clear();
                combinedResult.hidden = true;
                renderCombineBar();
                renderHybridResults();
            });
        }

        renderSelectedTags();
        renderHybridResults();
    </script>
</body>
</html>
