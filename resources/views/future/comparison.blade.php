<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Salīdzināšana</title>
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
                <p class="eyebrow">SALĪDZINĀŠANA</p>
                <h1>Divu spēļu salīdzinājums.</h1>
                <p>Salīdzini divu spēļu žanrus, platformas, izdošanas datumus un RAWG vērtējumus.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Salīdzinājuma panelis</h2>
                            <p>Spēles no RAWG kataloga</p>
                        </div>
                        <span class="filter-count" data-comparison-count>Notiek ielāde</span>
                    </div>

                    <form class="future-game-search" data-comparison-search-form>
                        <label for="comparison-game-search">Pievieno savu spēli</label>
                        <div class="future-game-search-controls">
                            <input id="comparison-game-search" type="search" maxlength="100" placeholder="Meklē pēc nosaukuma" data-comparison-search>
                            <button class="button button-secondary" type="submit">Meklēt</button>
                            <button class="future-search-clear" type="button" data-comparison-search-clear hidden>Notīrīt</button>
                        </div>
                    </form>
                    <p class="hybrid-search-status" data-comparison-search-status role="status" aria-live="polite"></p>
                    <div class="hybrid-results" data-comparison-search-results></div>

                    <div class="comparison-picker">
                        <div class="field">
                            <label for="comparison-first">Pirmā spēle</label>
                            <select id="comparison-first" data-comparison-first></select>
                        </div>
                        <div class="field">
                            <label for="comparison-second">Otrā spēle</label>
                            <select id="comparison-second" data-comparison-second></select>
                        </div>
                    </div>
                    <button class="button button-primary comparison-run-button" type="button" data-run-comparison>Salīdzināt spēles</button>
                    <p class="hybrid-search-status" data-comparison-status role="status">Notiek spēļu ielāde no kataloga...</p>

                    <div class="comparison-grid" data-comparison></div>
                </div>

                <aside class="side-tip comparison-insight" data-comparison-insight>
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div data-insight-default>
                        <div class="mini-label">Analīze</div>
                        <h2>Salīdzinājums pēc parametriem</h2>
                        <p>Izvēlies divas spēles, lai salīdzinātu to RAWG kataloga datus.</p>
                    </div>
                    <div data-insight-result hidden>
                        <div class="mini-label">TAVS SALĪDZINĀJUMS</div>
                        <div class="insight-score"><strong data-shared-count>0</strong><span>kopīgi parametri</span></div>
                        <h2 data-insight-title></h2>
                        <p data-insight-copy></p>
                        <div class="insight-tags" data-insight-tags></div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    @include('future.partials.games-api')
    <script>
        let comparisonGames = [];
        const comparison = document.querySelector('[data-comparison]');
        const firstSelect = document.querySelector('[data-comparison-first]');
        const secondSelect = document.querySelector('[data-comparison-second]');
        const runComparisonButton = document.querySelector('[data-run-comparison]');
        const insightDefault = document.querySelector('[data-insight-default]');
        const insightResult = document.querySelector('[data-insight-result]');
        const sharedCount = document.querySelector('[data-shared-count]');
        const insightTitle = document.querySelector('[data-insight-title]');
        const insightCopy = document.querySelector('[data-insight-copy]');
        const insightTags = document.querySelector('[data-insight-tags]');
        const comparisonCount = document.querySelector('[data-comparison-count]');
        const comparisonStatus = document.querySelector('[data-comparison-status]');
        const comparisonSearchForm = document.querySelector('[data-comparison-search-form]');
        const comparisonSearchInput = document.querySelector('[data-comparison-search]');
        const comparisonSearchClear = document.querySelector('[data-comparison-search-clear]');
        const comparisonSearchStatus = document.querySelector('[data-comparison-search-status]');
        const comparisonSearchResults = document.querySelector('[data-comparison-search-results]');
        let comparisonSearchGames = [];
        let comparisonRequestId = 0;
        let comparisonCatalogueLoaded = false;
        const pinnedComparisonGames = new Map();
        runComparisonButton.disabled = true;

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, (character) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;',
            }[character]));
        }

        function renderSelectors(preferredFirstId = firstSelect.value, preferredSecondId = secondSelect.value) {
            const options = comparisonGames.map((game) => `<option value="${game.id}">${escapeHtml(game.title)}</option>`).join('');
            firstSelect.innerHTML = options;
            secondSelect.innerHTML = options;
            firstSelect.value = comparisonGames.some((game) => String(game.id) === preferredFirstId)
                ? preferredFirstId
                : String(comparisonGames[0]?.id ?? '');
            secondSelect.value = comparisonGames.some((game) => String(game.id) === preferredSecondId)
                ? preferredSecondId
                : String(comparisonGames[1]?.id ?? comparisonGames[0]?.id ?? '');
            runComparisonButton.disabled = comparisonGames.length < 2;
            comparisonCount.textContent = `${comparisonGames.length} spēles`;
            comparisonStatus.textContent = comparisonGames.length < 2
                ? 'Salīdzināšanai nepieciešamas vismaz divas spēles.'
                : 'Izvēlies divas spēles no RAWG kataloga.';
        }

        async function searchComparisonGames() {
            const query = comparisonSearchInput.value.trim();
            const requestId = ++comparisonRequestId;
            comparisonSearchResults.innerHTML = '';

            if (!query) {
                comparisonSearchStatus.textContent = 'Ievadi spēles nosaukumu, ko pievienot salīdzinājumam.';
                comparisonSearchGames = [];
                comparisonSearchClear.hidden = true;
                return;
            }

            comparisonSearchClear.hidden = false;
            comparisonSearchStatus.textContent = `Meklē “${query}” RAWG katalogā...`;

            try {
                const games = await FutureGamesApi.list({ search: query, page_size: 8, ordering: '-rating' });
                if (requestId !== comparisonRequestId) {
                    return;
                }

                comparisonSearchGames = games;
                comparisonSearchStatus.textContent = games.length
                    ? `Atrastas ${games.length} spēles.`
                    : 'RAWG katalogā šāda spēle netika atrasta.';
                comparisonSearchResults.innerHTML = games.map((game) => `
                    <article class="hybrid-result-card">
                        ${game.thumbnail ? `<img src="${escapeHtml(game.thumbnail)}" alt="" loading="lazy" decoding="async">` : ''}
                        <div class="hybrid-result-info"><strong>${escapeHtml(game.title)}</strong><span>${escapeHtml(game.genre)} · ${escapeHtml(game.platform)}</span></div>
                            <button class="button button-secondary" type="button" data-add-comparison-game="${game.id}"${comparisonGames.some((item) => item.id === game.id) ? ' disabled' : ''}>${comparisonGames.some((item) => item.id === game.id) ? 'Pievienota' : 'Pievienot'}</button>
                    </article>
                `).join('');
            } catch (error) {
                if (requestId !== comparisonRequestId || error.name === 'AbortError') {
                    return;
                }

                comparisonSearchGames = [];
                comparisonSearchStatus.textContent = error.message;
            }
        }

        comparisonSearchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            searchComparisonGames();
        });

        comparisonSearchClear.addEventListener('click', () => {
            comparisonSearchInput.value = '';
            comparisonSearchResults.innerHTML = '';
            comparisonSearchStatus.textContent = '';
            comparisonSearchGames = [];
            comparisonSearchClear.hidden = true;
            comparisonSearchInput.focus();
        });

        comparisonSearchResults.addEventListener('click', (event) => {
            const button = event.target.closest('[data-add-comparison-game]');
            if (!button) {
                return;
            }

            const game = comparisonSearchGames.find((item) => String(item.id) === button.dataset.addComparisonGame);
            if (!game) {
                return;
            }

            const alreadyAdded = comparisonGames.some((item) => item.id === game.id);
            if (!alreadyAdded) {
                comparisonGames.push(game);
                if (!comparisonCatalogueLoaded) {
                    pinnedComparisonGames.set(game.id, game);
                }
            }

            const firstId = firstSelect.value;
            renderSelectors(firstId, String(game.id));
            comparisonStatus.textContent = alreadyAdded
                ? `${game.title} jau ir pieejama salīdzināšanai.`
                : `${game.title} pievienota salīdzināšanai.`;
            if (comparisonGames.length > 1) {
                renderComparison();
            }
        });

        function renderComparison() {
            const first = comparisonGames.find((game) => String(game.id) === firstSelect.value);
            const second = comparisonGames.find((game) => String(game.id) === secondSelect.value);
            if (!first || !second) {
                comparison.innerHTML = '';
                insightResult.hidden = true;
                insightDefault.hidden = false;
                return;
            }
            if (first.id === second.id) {
                comparisonStatus.textContent = 'Izvēlies divas dažādas spēles.';
                comparison.innerHTML = '';
                insightResult.hidden = true;
                insightDefault.hidden = false;
                return;
            }

            const sharedGenres = first.genres.filter((genre) => second.genres.includes(genre));
            const sharedPlatforms = first.platforms.filter((platform) => second.platforms.includes(platform));
            const sharedTraits = [
                sharedGenres.length ? 'kopīgs žanrs' : null,
                sharedPlatforms.length ? 'kopīga platforma' : null,
            ].filter(Boolean);
            const difference = first.genre !== second.genre
                ? `žanri: ${first.genre} pret ${second.genre}`
                : first.platform !== second.platform
                    ? `platformas: ${first.platform} pret ${second.platform}`
                    : `RAWG vērtējums: ${first.rating ?? 'nav norādīts'} pret ${second.rating ?? 'nav norādīts'}`;

            if (insightDefault && insightResult && sharedCount && insightTitle && insightCopy && insightTags) {
                insightDefault.hidden = true;
                insightResult.hidden = false;
                sharedCount.textContent = sharedTraits.length;
                insightTitle.textContent = sharedTraits.length ? 'Kopīgas iezīmes katalogā' : 'Atšķirīgas katalogu iezīmes';
                insightCopy.textContent = `${first.title} un ${second.title}: ${difference}.`;
                insightTags.innerHTML = sharedTraits.length
                    ? [...sharedGenres, ...sharedPlatforms].map((trait) => `<span>${escapeHtml(trait)}</span>`).join('')
                    : '<span>Nav kopīgu parametru</span>';
            }

            comparison.innerHTML = [first, second].map((game) => `
                <article class="comparison-card">
                    ${game.thumbnail ? `<img class="comparison-card-image" src="${escapeHtml(game.thumbnail)}" alt="${escapeHtml(game.title)} spēles attēls" loading="lazy" decoding="async">` : ''}
                    <h4>${escapeHtml(game.title)}</h4>
                    <div class="comparison-stat"><span>Žanrs</span><strong>${escapeHtml(game.genre)}</strong></div>
                    <div class="comparison-stat"><span>Platforma</span><strong>${escapeHtml(game.platform)}</strong></div>
                    <div class="comparison-stat"><span>Izlaista</span><strong>${escapeHtml(game.releaseDate ?? 'Nav norādīts')}</strong></div>
                    <div class="comparison-stat"><span>RAWG vērtējums</span><strong>${game.rating === null ? 'Nav vērtējuma' : `${escapeHtml(game.rating)}/5`}</strong></div>
                    <a href="${FutureGamesApi.detailUrl(game.id)}">Atvērt spēli</a>
                </article>
            `).join('') + `
                <div class="comparison-result-note">
                    <strong>${sharedTraits.length ? 'Kopīgais starp spēlēm' : 'Atšķirīgas spēles'}</strong>
                    <span>${sharedTraits.length ? [...sharedGenres, ...sharedPlatforms].map(escapeHtml).join(' · ') : 'Šīm spēlēm nav kopīgu žanru vai platformu.'}</span>
                </div>
            `;
            comparisonStatus.textContent = 'Salīdzinātas RAWG kataloga īpašības.';
        }

        runComparisonButton.addEventListener('click', renderComparison);
        [firstSelect, secondSelect].forEach((select) => {
            select.addEventListener('change', () => {
                comparison.innerHTML = '';
                insightResult.hidden = true;
                insightDefault.hidden = false;
                comparisonStatus.textContent = 'Nospied salīdzināšanas pogu, lai atjaunotu rezultātu.';
            });
        });
        FutureGamesApi.list({ page_size: 24, ordering: '-rating' })
            .then((games) => {
                comparisonCatalogueLoaded = true;
                comparisonGames = [...games];
                pinnedComparisonGames.forEach((game) => {
                    if (!comparisonGames.some((item) => item.id === game.id)) {
                        comparisonGames.push(game);
                    }
                });
                renderSelectors();
                if (games.length > 1) {
                    renderComparison();
                }
            })
            .catch((error) => {
                comparisonCount.textContent = 'Nav pieejams';
                comparisonStatus.textContent = error.message;
                comparison.innerHTML = '';
                runComparisonButton.disabled = true;
            });
    </script>
</body>
</html>
