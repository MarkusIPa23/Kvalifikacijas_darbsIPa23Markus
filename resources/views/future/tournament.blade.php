<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Turnīrs</title>
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
                <p class="eyebrow">TURNĪRS</p>
                <h1>Izvēlies uzvarētāju.</h1>
                <p>Katrā pārī izvēlies sev tīkamāko spēli, līdz turnīrā paliek viens uzvarētājs.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Turnīra izvēle</h2>
                            <p>Izvēlies savu iecienītāko variantu</p>
                        </div>
                        <span class="filter-count" data-candidate-count>Notiek ielāde</span>
                    </div>

                    <div class="tournament-actions">
                        <button class="button button-primary" type="button" data-start-tournament disabled>Sākt turnīru</button>
                        <button class="button button-secondary" type="button" data-shuffle-games disabled>Sajaukt spēles</button>
                        <button class="button button-secondary" type="button" data-random-tournament-games disabled>Nejaušas spēles</button>
                        <button class="button button-secondary" type="button" data-reset-selection>Jauns turnīrs</button>
                    </div>
                    <p class="tournament-status" data-tournament-status>Izveido savu spēļu sarakstu un sāc turnīru.</p>

                    <div class="tournament-setup" data-tournament-setup>
                        <div class="tournament-setup-heading">
                            <div>
                                <strong>Manas turnīra spēles</strong>
                                <span>Izvēlies vismaz 4 spēles no RAWG kataloga.</span>
                            </div>
                            <span class="filter-count" data-setup-count>Notiek ielāde</span>
                        </div>
                        <div class="add-game-form">
                            <input type="search" maxlength="100" placeholder="Meklēt RAWG spēles" aria-label="Meklēt RAWG spēles" data-game-name-input>
                            <button class="button button-secondary" type="button" data-add-game>Meklēt katalogā</button>
                        </div>
                        <div class="hybrid-results" data-api-search-results></div>
                        <div class="game-selection-tools">
                            <input type="search" placeholder="Meklēt izvēlētajās spēlēs" aria-label="Meklēt izvēlētajās spēlēs" data-search-games>
                        </div>
                        <div class="custom-game-list" data-custom-game-list></div>
                    </div>

                    <div class="tournament-grid" data-tournament></div>
                </div>

                <aside class="side-tip" data-winner-panel>
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div data-winner-default>
                        <div class="mini-label">Konkursā</div>
                        <h2>Uzvarētājs seko jūsu vēlmēm</h2>
                        <p>Izvēlies favorītu katrā pārī. Tavs turnīra čempions parādīsies šeit.</p>
                    </div>
                    <div class="winner-result" data-winner-result hidden>
                        <div class="mini-label">TURNĪRA ČEMPIONS</div>
                        <img data-winner-image src="" alt="">
                        <p class="winner-result-label">Tava izvēle</p>
                        <h2 data-winner-name></h2>
                        <p>Šī spēle uzvarēja visās tavās izvēlēs.</p>
                        <button class="button button-secondary" type="button" data-side-reset>Spēlēt vēlreiz</button>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    @include('future.partials.games-api')
    <script>
        const fallbackImage = 'https://placehold.co/640x360/e9edf3/61708a?text=Game';
        const tournament = document.querySelector('[data-tournament]');
        const candidateCounter = document.querySelector('[data-candidate-count]');
        const startTournamentButton = document.querySelector('[data-start-tournament]');
        const shuffleGamesButton = document.querySelector('[data-shuffle-games]');
        const randomTournamentGamesButton = document.querySelector('[data-random-tournament-games]');
        const resetSelectionButton = document.querySelector('[data-reset-selection]');
        const setup = document.querySelector('[data-tournament-setup]');
        const setupCount = document.querySelector('[data-setup-count]');
        const customGameList = document.querySelector('[data-custom-game-list]');
        const gameNameInput = document.querySelector('[data-game-name-input]');
        const addGameButton = document.querySelector('[data-add-game]');
        const apiSearchResults = document.querySelector('[data-api-search-results]');
        const searchGamesInput = document.querySelector('[data-search-games]');
        const tournamentStatus = document.querySelector('[data-tournament-status]');
        const winnerDefault = document.querySelector('[data-winner-default]');
        const winnerResult = document.querySelector('[data-winner-result]');
        const winnerImage = document.querySelector('[data-winner-image]');
        const winnerName = document.querySelector('[data-winner-name]');
        const sideResetButton = document.querySelector('[data-side-reset]');
        let candidates = [];
        let searchResults = [];
        let searchRequestId = 0;
        let candidateListChanged = false;
        let catalogueLoaded = false;

        let tournamentState = {
            round: 0,
            winners: [],
            champion: null,
            completedRounds: [],
        };

        let rounds = [];

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, (character) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;',
            }[character]));
        }

        function gameKey(game) {
            return String(game.id);
        }

        function normalizeTournamentGame(game) {
            return {
                id: game.id,
                name: game.title,
                genre: game.genre,
                style: game.platform,
                image: game.thumbnail || fallbackImage,
                genres: game.genres,
                platforms: game.platforms,
                rating: game.rating,
            };
        }

        function shuffleGames(games) {
            const shuffledGames = [...games];

            for (let index = shuffledGames.length - 1; index > 0; index -= 1) {
                const swapIndex = Math.floor(Math.random() * (index + 1));
                [shuffledGames[index], shuffledGames[swapIndex]] = [shuffledGames[swapIndex], shuffledGames[index]];
            }

            return shuffledGames;
        }

        function showChampion(game) {
            if (!winnerDefault || !winnerResult || !winnerImage || !winnerName) {
                return;
            }

            winnerDefault.hidden = true;
            winnerResult.hidden = false;
            winnerImage.src = game.image;
            winnerImage.alt = `${game.name} spēles attēls`;
            winnerName.textContent = game.name;
        }

        function clearChampion() {
            if (!winnerDefault || !winnerResult) {
                return;
            }

            winnerDefault.hidden = false;
            winnerResult.hidden = true;
        }

        function setTournamentStatus(message, type = '') {
            if (!tournamentStatus) {
                return;
            }

            tournamentStatus.textContent = message;
            tournamentStatus.className = `tournament-status ${type}`.trim();
        }

        function updateSetupAvailability(isRunning) {
            if (setup) {
                setup.hidden = isRunning;
            }
            if (shuffleGamesButton) {
                shuffleGamesButton.disabled = isRunning || !catalogueLoaded || candidates.length < 2;
            }
            if (randomTournamentGamesButton) {
                randomTournamentGamesButton.disabled = isRunning || !catalogueLoaded;
            }
            if (startTournamentButton) {
                startTournamentButton.disabled = isRunning || candidates.length < 4;
            }
        }

        function advanceByes(round) {
            const automaticWinners = createPairings(round.games)
                .filter(([first, second]) => first.isBye !== second.isBye)
                .map(([first, second]) => first.isBye ? second : first);

            automaticWinners.forEach((game) => {
                if (!tournamentState.winners.some((winner) => winner.id === game.id)) {
                    tournamentState.winners.push(game);
                }
            });
        }

        function createPairings(games) {
            const pairings = [];
            for (let index = 0; index < games.length; index += 2) {
                pairings.push(games.slice(index, index + 2));
            }
            return pairings;
        }

        function getBracketPool(games) {
            const pool = games.slice(0, 16);
            let bracketSize = 4;

            while (bracketSize < pool.length) {
                bracketSize *= 2;
            }

            while (pool.length < bracketSize) {
                pool.push({ name: 'Brīva vieta', genre: 'Bye', style: 'Automātiski tālāk', image: 'https://placehold.co/640x360/e9edf3/61708a?text=BYE', isBye: true });
            }

            return pool;
        }

        function renderSetup() {
            if (!customGameList || !setupCount) {
                return;
            }

            setupCount.textContent = `${candidates.length} spēles`;
            if (candidateCounter) {
                candidateCounter.textContent = `${candidates.length} kandidāti`;
            }
            updateSetupAvailability(tournamentState.round > 0 && tournamentState.round < rounds.length);
            const query = searchGamesInput ? searchGamesInput.value.trim().toLowerCase() : '';
            const visibleGames = candidates
                .map((game, index) => ({ game, index }))
                .filter(({ game }) => (game.name ?? '').toLowerCase().includes(query))
                .sort((first, second) => first.index - second.index);

            customGameList.innerHTML = visibleGames.length
                ? visibleGames.map(({ game, index }) => `
                    <article class="custom-game-card">
                        <img src="${escapeHtml(game.image ?? fallbackImage)}" alt="${escapeHtml(game.name ?? 'Spēle')} spēles attēls" loading="lazy" decoding="async">
                        <div>
                            <strong>${escapeHtml(game.name ?? 'Nezināma spēle')}</strong>
                            <span>${escapeHtml(game.genre ?? 'Nezināms žanrs')} · ${escapeHtml(game.style ?? 'Nezināma platforma')}</span>
                        </div>
                        <button type="button" aria-label="Noņemt ${escapeHtml(game.name ?? 'spēli')}" data-remove-game="${index}"${candidates.length <= 4 ? ' disabled' : ''}>×</button>
                    </article>
                `).join('')
                : `<p class="game-search-empty">${query ? 'Spēle netika atrasta.' : 'RAWG katalogā nav pieejamu spēļu.'}</p>`;
        }

        function clearCompletedTournamentAfterRosterChange() {
            if (tournamentState.round && tournamentState.round === rounds.length) {
                tournamentState = { round: 0, winners: [], champion: null, completedRounds: [] };
                rounds = [];
                clearChampion();
                renderTournament();
            }
        }

        function renderMatch(pair, matchIndex) {
            const [first, second] = pair;

            if (first.isBye || second.isBye) {
                const activeGame = first.isBye ? second : first;
                return `
                    <article class="bracket-match bracket-match--bye">
                        <div class="bracket-match-topline"><span class="bracket-match-label">Mačs ${matchIndex + 1}</span><span class="bracket-confidence">Brīva vieta</span></div>
                        <button class="bracket-contender is-winner" type="button" data-bracket-winner="${gameKey(activeGame)}">
                            <img src="${escapeHtml(activeGame.image)}" alt="" loading="lazy" decoding="async">
                            <span><i>${escapeHtml(activeGame.genre)}</i>${escapeHtml(activeGame.name)}</span><strong>TĀLĀK</strong>
                        </button>
                        <p class="bracket-bye-note">Šai spēlei nav pretinieka.</p>
                    </article>
                `;
            }

            return `
                <article class="bracket-match">
                    <div class="bracket-match-topline">
                        <span class="bracket-match-label">Mačs ${matchIndex + 1}</span>
                        <span class="bracket-confidence">Tava izvēle</span>
                    </div>
                    <button class="bracket-contender" type="button" data-bracket-winner="${gameKey(first)}">
                        <img src="${escapeHtml(first.image)}" alt="" loading="lazy" decoding="async">
                        <span><i>${escapeHtml(first.genre)}</i>${escapeHtml(first.name)}</span>
                    </button>
                    <div class="bracket-versus">VS</div>
                    <button class="bracket-contender" type="button" data-bracket-winner="${gameKey(second)}">
                        <img src="${escapeHtml(second.image)}" alt="" loading="lazy" decoding="async">
                        <span><i>${escapeHtml(second.genre)}</i>${escapeHtml(second.name)}</span>
                    </button>
                    <p class="bracket-choice-hint">Uzspied uz spēles, kura tev patīk vairāk.</p>
                </article>
            `;
        }

        function renderTournament() {
            if (!tournamentState.round) {
                updateSetupAvailability(false);
                setTournamentStatus('Izveido savu spēļu sarakstu un sāc turnīru.');
                tournament.innerHTML = `
                    <div class="bracket-empty">
                        <span class="bracket-trophy" aria-hidden="true">🏆</span>
                        <strong>Gatavs lielajam mačam?</strong>
                        <p>Spēles tiks saliktas pāros, un katrā mačā tu pats izvēlēsies savu favorītu.</p>
                    </div>
                `;
                return;
            }

            const round = rounds[tournamentState.round - 1];
            advanceByes(round);
            const pairings = createPairings(round.games).filter(([first, second]) => !first.isBye && !second.isBye);
            updateSetupAvailability(true);
            setTournamentStatus(`Kārta ${tournamentState.round}: izvēlies uzvarētāju ${pairings.length} īstajos mačos.`);
            tournament.innerHTML = `
                <div class="bracket-progress" style="--round-count: ${rounds.length}" aria-label="Turnīra progress">
                    ${rounds.map((item, index) => `<span class="${index + 1 <= tournamentState.round ? 'is-active' : ''}">${index + 1}. ${item.name}</span>`).join('')}
                </div>
                ${tournamentState.completedRounds.map((completedRound) => `
                    <div class="bracket-history"><strong>${escapeHtml(completedRound.name)}</strong><span>${completedRound.winners.map((game) => escapeHtml(game.name)).join(' · ')}</span></div>
                `).join('')}
                <div class="bracket-heading">
                    <div>
                        <span class="mini-label">KĀRTA ${tournamentState.round} / ${rounds.length}</span>
                        <h3>${round.name}</h3>
                    </div>
                    <span class="filter-count">${pairings.length} mači</span>
                </div>
                <div class="bracket-round">
                    ${pairings.map((pair, index) => renderMatch(pair, index)).join('')}
                </div>
            `;

            if (candidateCounter) {
                candidateCounter.textContent = `${round.games.length} kandidāti`;
            }
        }

        tournament.addEventListener('click', (event) => {
            const pick = event.target.closest('[data-bracket-winner]');
            if (!pick) {
                return;
            }

            const match = pick.closest('.bracket-match');
            if (match?.dataset.selected) {
                return;
            }
            if (match) {
                match.dataset.selected = 'true';
                pick.classList.add('is-picked');
                match.querySelectorAll('button').forEach((button) => {
                    button.disabled = true;
                });
            }

            const selectedWinner = candidates.find((game) => gameKey(game) === pick.dataset.bracketWinner);
            if (!selectedWinner) {
                return;
            }
            if (tournamentState.winners.some((game) => game.id === selectedWinner.id)) {
                return;
            }
            tournamentState.winners.push(selectedWinner);
            const currentRound = rounds[tournamentState.round - 1];
            const expectedWinners = Math.ceil(currentRound.games.filter((game) => !game.isBye).length / 2);
            setTournamentStatus(`Izvēle saglabāta. Atlikušas ${expectedWinners - tournamentState.winners.length} spēles šajā kārtā.`);

            if (tournamentState.winners.length < expectedWinners) {
                pick.disabled = true;
                pick.textContent = 'Uzvarētājs izvēlēts';
                return;
            }

            if (tournamentState.round === rounds.length) {
                tournamentState.champion = tournamentState.winners[0];
                tournament.innerHTML = `
                    <div class="bracket-complete">
                        <span class="bracket-trophy" aria-hidden="true">🏆</span>
                        <strong>Turnīrs pabeigts</strong>
                        <p>Čempions ir parādīts panelī blakus.</p>
                    </div>
                `;
                showChampion(tournamentState.champion);
                candidateCounter.textContent = 'Uzvarētājs atrasts';
                updateSetupAvailability(false);
                setTournamentStatus('Turnīrs pabeigts. Čempions ir redzams labajā panelī.', 'is-complete');
                return;
            }

            tournamentState.completedRounds.push({ name: currentRound.name, winners: [...tournamentState.winners] });
            rounds[tournamentState.round].games = getBracketPool(tournamentState.winners);
            tournamentState.winners = [];
            tournamentState.round += 1;
            renderTournament();
        });

        if (startTournamentButton) {
            startTournamentButton.addEventListener('click', () => {
                if (candidates.length < 4) {
                    setTournamentStatus('Pievieno vismaz 4 spēles, lai sāktu turnīru.', 'is-error');
                    return;
                }

                tournamentState = { round: 1, winners: [], champion: null, completedRounds: [] };
                clearChampion();
                const initialBracket = getBracketPool(candidates);
                const roundNames = {
                    4: ['Pusfināli', 'Fināls'],
                    8: ['Ceturtdaļfināli', 'Pusfināli', 'Fināls'],
                    16: ['Astotdaļfināli', 'Ceturtdaļfināli', 'Pusfināli', 'Fināls'],
                };
                rounds = roundNames[initialBracket.length].map((name) => ({ name, games: [] }));
                rounds[0].games = initialBracket;
                if (setup) {
                    setup.hidden = true;
                }
                setTournamentStatus('Turnīrs sākts. Izvēlies vienu spēli katrā pārī.');
                renderTournament();
            });
        }

        if (shuffleGamesButton) {
            shuffleGamesButton.addEventListener('click', () => {
                candidates = shuffleGames(candidates);
                candidateListChanged = true;
                renderSetup();
            });
        }

        if (randomTournamentGamesButton) {
            randomTournamentGamesButton.addEventListener('click', async () => {
                randomTournamentGamesButton.disabled = true;
                setTournamentStatus('Ielādē nejaušas spēles no RAWG...');

                try {
                    const games = await FutureGamesApi.list({ page_size: 40, ordering: '-rating' });

                    if (games.length < 4) {
                        throw new Error('RAWG katalogā nav pietiekami daudz spēļu turnīram.');
                    }

                    const gamePool = games.map(normalizeTournamentGame);
                    candidates = shuffleGames(gamePool).slice(0, Math.min(8, gamePool.length));
                    candidateListChanged = true;
                    tournamentState = { round: 0, winners: [], champion: null, completedRounds: [] };
                    rounds = [];
                    clearChampion();
                    setup.hidden = false;
                    renderSetup();
                    renderTournament();
                    setTournamentStatus(`Ielādētas ${candidates.length} nejaušas spēles no RAWG. Pārbaudi sarakstu un sāc turnīru.`);
                } catch (error) {
                    setTournamentStatus(error.message || 'Neizdevās ielādēt spēles no RAWG.', 'is-error');
                } finally {
                    randomTournamentGamesButton.disabled = false;
                }
            });
        }

        if (resetSelectionButton) {
            resetSelectionButton.addEventListener('click', () => {
                tournamentState = { round: 0, winners: [], champion: null, completedRounds: [] };
                clearChampion();
                rounds = [];
                if (setup) {
                    setup.hidden = false;
                }
                setTournamentStatus('Jauns turnīrs gatavs. Vari mainīt spēļu sarakstu.');
                renderTournament();
            });
        }

        if (addGameButton) {
            addGameButton.addEventListener('click', async () => {
                const name = gameNameInput.value.trim();
                if (!name) {
                    apiSearchResults.innerHTML = '<p class="game-search-empty">Ievadi spēles nosaukumu.</p>';
                    return;
                }

                if (candidates.length >= 16) {
                    setTournamentStatus('Turnīrā var pievienot ne vairāk kā 16 spēles.', 'is-error');
                    return;
                }

                apiSearchResults.textContent = 'Meklē RAWG katalogā...';
                searchResults = [];
                const requestId = ++searchRequestId;
                try {
                    const results = await FutureGamesApi.list({ search: name, page_size: 8, ordering: '-rating' });
                    if (requestId !== searchRequestId) {
                        return;
                    }

                    searchResults = results;
                    apiSearchResults.innerHTML = searchResults.length
                        ? searchResults.map((game) => `
                            <article class="hybrid-result-card">
                                ${game.thumbnail ? `<img src="${escapeHtml(game.thumbnail)}" alt="" loading="lazy" decoding="async">` : ''}
                                <div class="hybrid-result-info"><strong>${escapeHtml(game.title)}</strong><span>${escapeHtml(game.genre)} · ${escapeHtml(game.platform)}</span></div>
                                <button class="button button-secondary" type="button" data-add-api-game="${game.id}">Pievienot</button>
                            </article>
                        `).join('')
                        : '<p class="game-search-empty">RAWG katalogā spēle netika atrasta.</p>';
                } catch (error) {
                    if (requestId !== searchRequestId || error.name === 'AbortError') {
                        return;
                    }

                    searchResults = [];
                    apiSearchResults.textContent = error.message;
                }
            });
        }

        gameNameInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                addGameButton.click();
            }
        });

        if (apiSearchResults) {
            apiSearchResults.addEventListener('click', (event) => {
                const button = event.target.closest('[data-add-api-game]');
                if (!button) return;

                const game = searchResults.find((result) => String(result.id) === button.dataset.addApiGame);
                if (!game || candidates.some((candidate) => candidate.id === game.id)) {
                    setTournamentStatus('Šī spēle jau ir turnīra sarakstā.', 'is-error');
                    return;
                }
                if (candidates.length >= 16) {
                    setTournamentStatus('Turnīrā var pievienot ne vairāk kā 16 spēles.', 'is-error');
                    return;
                }

                candidates.push(normalizeTournamentGame(game));
                candidateListChanged = true;
                clearCompletedTournamentAfterRosterChange();
                renderSetup();
                setTournamentStatus(`${game.title} pievienota turnīram.`);
            });
        }

        if (searchGamesInput) {
            searchGamesInput.addEventListener('input', renderSetup);
        }

        if (sideResetButton) {
            sideResetButton.addEventListener('click', () => {
                resetSelectionButton.click();
            });
        }

        if (customGameList) {
            customGameList.addEventListener('click', (event) => {
                const removeButton = event.target.closest('[data-remove-game]');
                if (!removeButton || candidates.length <= 4) {
                    return;
                }

                candidates.splice(Number(removeButton.dataset.removeGame), 1);
                candidateListChanged = true;
                clearCompletedTournamentAfterRosterChange();
                renderSetup();
            });
        }

        renderSetup();
        renderTournament();
        FutureGamesApi.list({ page_size: 40, ordering: '-rating' })
            .then((games) => {
                if (!candidateListChanged) {
                    candidates = games.slice(0, 8).map(normalizeTournamentGame);
                }
                catalogueLoaded = true;
                renderSetup();
                renderTournament();
                setTournamentStatus(games.length >= 4
                    ? 'Spēļu saraksts ielādēts no RAWG kataloga.'
                    : 'RAWG katalogā pašlaik nav pietiekami daudz spēļu turnīram.', games.length >= 4 ? '' : 'is-error');
            })
            .catch((error) => {
                catalogueLoaded = true;
                updateSetupAvailability(false);
                setTournamentStatus(error.message, 'is-error');
            });
    </script>
</body>
</html>
