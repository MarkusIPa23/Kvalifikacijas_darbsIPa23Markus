<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Hibrīda veidotājs</title>
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
                <p class="eyebrow">HIBRĪDA VEIDOTĀJS</p>
                <h1>Izvēlies savas spēles iezīmes.</h1>
                <p>Veidotājs apvieno žanra, stila un gaumes prioritātes, lai izveidotu personalizētu spēļu izvēli.</p>
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
                                <button class="tag-option is-selected" type="button">RPG</button>
                                <button class="tag-option is-selected" type="button">Action</button>
                                <button class="tag-option" type="button">Co-op</button>
                                <button class="tag-option" type="button">Story</button>
                                <button class="tag-option is-selected" type="button">Open World</button>
                                <button class="tag-option" type="button">Indie</button>
                                <button class="tag-option" type="button">Competitive</button>
                                <button class="tag-option" type="button">Relaxed</button>
                                <button class="tag-option" type="button">Strategy</button>
                                <button class="tag-option" type="button">Simulation</button>
                                <button class="tag-option" type="button">Racing</button>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px;">
                        <button class="button button-secondary" type="button" data-select-all-tags>Izvēlēties visas iezīmes</button>
                        <button class="button button-secondary" type="button" data-clear-tags>Notīrīt atlasi</button>
                    </div>

                    <div class="feature-summary">
                        <strong>Pašlaik atlasīts:</strong>
                        <span data-selected-tags>RPG, Action, Open World</span>
                    </div>
                    <button class="button button-primary hybrid-search-button" type="button" data-find-games>
                        Meklēt spēles pēc žanriem
                    </button>
                    <button class="button button-secondary hybrid-all-games-button" type="button" data-show-all-games>
                        Rādīt visas spēles
                    </button>
                    <p class="hybrid-search-status" data-search-status>Izvēlies žanrus un nospied meklēšanas pogu.</p>
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

    <script>
        const tagButtons = [...document.querySelectorAll('[data-preferences] .tag-option')];
        const selectedTags = document.querySelector('[data-selected-tags]');
        const selectAllButton = document.querySelector('[data-select-all-tags]');
        const clearTagsButton = document.querySelector('[data-clear-tags]');
        const findGamesButton = document.querySelector('[data-find-games]');
        const showAllGamesButton = document.querySelector('[data-show-all-games]');
        const searchStatus = document.querySelector('[data-search-status]');
        const hybridResults = document.querySelector('[data-hybrid-results]');
        const combineBar = document.querySelector('[data-combine-bar]');
        const combineCount = document.querySelector('[data-combine-count]');
        const combineGamesButton = document.querySelector('[data-combine-games]');
        const combinedResult = document.querySelector('[data-combined-result]');

        const hybridGames = [
            { name: 'The Witcher 3', genre: 'RPG', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg' },
            { name: 'Counter-Strike 2', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/730/header.jpg' },
            { name: 'Stardew Valley', genre: 'RPG', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/413150/header.jpg' },
            { name: 'Hades', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1145360/header.jpg' },
            { name: 'Portal 2', genre: 'Action', style: 'Co-op', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/620/header.jpg' },
            { name: 'Red Dead Redemption 2', genre: 'Action', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1174180/header.jpg' },
            { name: 'Terraria', genre: 'RPG', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/105600/header.jpg' },
            { name: 'Skyrim', genre: 'RPG', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/489830/header.jpg' },
            { name: 'Minecraft', genre: 'RPG', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1672970/header.jpg' },
            { name: 'Grand Theft Auto V', genre: 'Action', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/271590/header.jpg' },
            { name: 'Hollow Knight', genre: 'Indie', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg' },
            { name: 'Fallout 4', genre: 'RPG', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/377160/header.jpg' },
            { name: 'Cyberpunk 2077', genre: 'RPG', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg' },
            { name: 'Valheim', genre: 'Co-op', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/892970/header.jpg' },
            { name: 'Among Us', genre: 'Co-op', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/945360/header.jpg' },
            { name: 'Dead Cells', genre: 'Action', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/588650/header.jpg' },
            { name: 'Baldur\'s Gate 3', genre: 'RPG', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1086940/header.jpg' },
            { name: 'Elden Ring', genre: 'RPG', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg' },
            { name: 'It Takes Two', genre: 'Co-op', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1426210/header.jpg' },
            { name: 'Dota 2', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/570/header.jpg' },
            { name: 'Subnautica', genre: 'Indie', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/264710/header.jpg' },
            { name: 'Sea of Thieves', genre: 'Co-op', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1172620/header.jpg' },
            { name: 'Deep Rock Galactic', genre: 'Co-op', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/548430/header.jpg' },
            { name: 'Risk of Rain 2', genre: 'Action', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/632360/header.jpg' },
            { name: 'Civilization VI', genre: 'Strategy', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/289070/header.jpg' },
            { name: 'Total War: WARHAMMER III', genre: 'Strategy', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1142710/header.jpg' },
            { name: 'Slay the Spire', genre: 'Strategy', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/646570/header.jpg' },
            { name: 'The Sims 4', genre: 'Simulation', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1222670/header.jpg' },
            { name: 'Euro Truck Simulator 2', genre: 'Simulation', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/227300/header.jpg' },
            { name: 'Trackmania', genre: 'Racing', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2225070/header.jpg' },
            { name: 'Forza Horizon 5', genre: 'Racing', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg' },
            { name: 'Ori and the Will of the Wisps', genre: 'Indie', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1057090/header.jpg' },
            { name: 'Apex Legends', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1172470/header.jpg' },
            { name: 'Deep Rock Galactic: Survivor', genre: 'Action', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2321470/header.jpg' },
        ];

        const prototypeState = {
            selectedTags: tagButtons
                .filter((button) => button.classList.contains('is-selected'))
                .map((button) => button.textContent.trim()),
            showAllGames: false,
            selectedGames: [],
        };

        function syncTagSelection() {
            tagButtons.forEach((button) => {
                const label = button.textContent.trim();
                button.classList.toggle('is-selected', prototypeState.selectedTags.includes(label));
            });
        }

        function renderSelectedTags() {
            if (selectedTags) {
                selectedTags.textContent = prototypeState.selectedTags.join(', ') || 'Nav atlasītu iezīmju';
            }
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
            if (!hybridResults || !searchStatus) {
                return;
            }

            if (!prototypeState.selectedTags.length && !prototypeState.showAllGames) {
                searchStatus.textContent = 'Izvēlies vismaz vienu žanru, lai atrastu spēles.';
                hybridResults.innerHTML = '';
                return;
            }

            const results = prototypeState.showAllGames
                ? hybridGames
                : hybridGames.filter((game) => prototypeState.selectedTags.some((tag) => [game.genre, game.style].includes(tag)));
            searchStatus.textContent = prototypeState.showAllGames
                ? `Parādītas visas ${results.length} pieejamās spēles.`
                : `Atrastas ${results.length} spēles pēc tavām izvēlēm.`;
            showAllGamesButton.textContent = prototypeState.showAllGames ? 'Rādīt pēc žanriem' : 'Rādīt visas spēles';
            hybridResults.innerHTML = results.length
                ? results.map((game) => `
                    <article class="hybrid-result-card ${prototypeState.selectedGames.includes(game.name) ? 'is-chosen' : ''}">
                        <img src="${escapeHtml(game.image)}" alt="${escapeHtml(game.name)} spēles attēls">
                        <div class="hybrid-result-info">
                            <strong>${escapeHtml(game.name)}</strong>
                            <span>${escapeHtml(game.genre)} · ${escapeHtml(game.style)}</span>
                        </div>
                        <button class="button button-secondary ${prototypeState.selectedGames.includes(game.name) ? 'is-selected' : ''}" type="button" data-select-game="${escapeHtml(game.name)}">
                            ${prototypeState.selectedGames.includes(game.name) ? 'Izvēlēta' : 'Izvēlēties'}
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
            const selectedNames = selectedGames.map((game) => game.name);
            const selectedGenres = [...new Set(selectedGames.map((game) => game.genre))];
            const selectedStyles = [...new Set(selectedGames.map((game) => game.style))];

            return hybridGames
                .filter((game) => !selectedNames.includes(game.name))
                .map((game) => ({
                    game,
                    score: (selectedGenres.includes(game.genre) ? 2 : 0) + (selectedStyles.includes(game.style) ? 1 : 0),
                }))
                .sort((first, second) => second.score - first.score)[0]?.game;
        }

        tagButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const label = button.textContent.trim();
                const index = prototypeState.selectedTags.indexOf(label);

                if (index >= 0) {
                    prototypeState.selectedTags.splice(index, 1);
                    prototypeState.showAllGames = false;
                } else {
                    prototypeState.selectedTags.push(label);
                }

                syncTagSelection();
                renderSelectedTags();
            });
        });

        if (selectAllButton) {
            selectAllButton.addEventListener('click', () => {
                prototypeState.selectedTags = tagButtons.map((button) => button.textContent.trim());
                prototypeState.showAllGames = false;
                syncTagSelection();
                renderSelectedTags();
            });
        }

        if (clearTagsButton) {
            clearTagsButton.addEventListener('click', () => {
                prototypeState.selectedTags = [];
                prototypeState.showAllGames = false;
                syncTagSelection();
                renderSelectedTags();
            });
        }

        if (findGamesButton) {
            findGamesButton.addEventListener('click', renderHybridResults);
        }

        if (showAllGamesButton) {
            showAllGamesButton.addEventListener('click', () => {
                prototypeState.showAllGames = !prototypeState.showAllGames;
                renderHybridResults();
            });
        }

        if (hybridResults) {
            hybridResults.addEventListener('click', (event) => {
                const button = event.target.closest('[data-select-game]');
                if (!button) {
                    return;
                }

                const gameName = button.dataset.selectGame;
                const selectedIndex = prototypeState.selectedGames.indexOf(gameName);
                if (selectedIndex >= 0) {
                    prototypeState.selectedGames.splice(selectedIndex, 1);
                } else {
                    prototypeState.selectedGames.push(gameName);
                }

                searchStatus.textContent = `${prototypeState.selectedGames.length} spēles izvēlētas apvienošanai.`;
                renderHybridResults();
            });
        }

        if (combineGamesButton) {
            combineGamesButton.addEventListener('click', () => {
                const selected = hybridGames.filter((game) => prototypeState.selectedGames.includes(game.name));
                if (selected.length < 2 || !combinedResult) {
                    return;
                }

                const genres = [...new Set(selected.map((game) => game.genre))].join(' + ');
                const styles = [...new Set(selected.map((game) => game.style))].join(' + ');
                const gameNames = selected.map((game) => game.name).join(' × ');
                const genreList = [...new Set(selected.map((game) => game.genre))];
                const styleList = [...new Set(selected.map((game) => game.style))];
                const hybridName = `${genres}: ${createUniqueHybridName(genreList)}`;
                const sourceCount = selected.length;
                const similarGame = findSimilarGame(selected);
                combinedResult.hidden = false;
                combinedResult.innerHTML = `
                    <div class="hybrid-combined-heading"><span class="mini-label">JAUNA UNIKĀLA SPĒLE</span><strong>${sourceCount} spēļu kombinācija</strong></div>
                    <div class="hybrid-combined-games">${selected.map((game) => `<img src="${escapeHtml(game.image)}" alt="${escapeHtml(game.name)}">`).join('')}</div>
                    <h3>${escapeHtml(hybridName)}</h3>
                    <p class="hybrid-combined-description">Unikāla spēles ideja, kas apvieno ${escapeHtml(gameNames)} labākās īpašības vienā pasaulē.</p>
                    <div class="hybrid-combined-section"><strong>Precīzie apvienotie žanri</strong><div class="hybrid-combined-tags">${genreList.map((genre) => `<span>${escapeHtml(genre)}</span>`).join('')}</div></div>
                    <div class="hybrid-combined-section"><strong>Apvienotie stili</strong><div class="hybrid-combined-tags">${styleList.map((style) => `<span>${escapeHtml(style)}</span>`).join('')}</div></div>
                    ${similarGame ? `
                        <div class="hybrid-similar-result">
                            <div class="hybrid-similar-label">LĪDZĪGA SPĒLE PĒC ŽANRIEM</div>
                            <img src="${escapeHtml(similarGame.image)}" alt="${escapeHtml(similarGame.name)} spēles attēls">
                            <div><strong>${escapeHtml(similarGame.name)}</strong><span>${escapeHtml(similarGame.genre)} · ${escapeHtml(similarGame.style)}</span></div>
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
                combinedResult.hidden = true;
                renderHybridResults();
            });
        }

        renderSelectedTags();
    </script>
</body>
</html>
