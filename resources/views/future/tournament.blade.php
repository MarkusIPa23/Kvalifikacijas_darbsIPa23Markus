<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Turnīrs</title>
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
                <p class="eyebrow">TURNĪRS</p>
                <h1>Izvēlies uzvarētāju.</h1>
                <p>Katrs kandidāts konkursā tiek salīdzināts pēc gaumes, stila un atbilstības, līdz paliek viens uzvarētājs.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Turnīra izvēle</h2>
                            <p>Izvēlies savu iecienītāko variantu</p>
                        </div>
                        <span class="filter-count" data-candidate-count>8 kandidāti</span>
                    </div>

                    <div class="tournament-actions">
                        <button class="button button-primary" type="button" data-start-tournament>Sākt turnīru</button>
                        <button class="button button-secondary" type="button" data-shuffle-games>Sajaukt spēles</button>
                        <button class="button button-secondary" type="button" data-random-tournament-games>8 random spēles</button>
                        <button class="button button-secondary" type="button" data-reset-selection>Jauns turnīrs</button>
                    </div>
                    <p class="tournament-status" data-tournament-status>Izveido savu spēļu sarakstu un sāc turnīru.</p>

                    <div class="tournament-setup" data-tournament-setup>
                        <div class="tournament-setup-heading">
                            <div>
                                <strong>Manas turnīra spēles</strong>
                                <span>Izvēlies vismaz 4 spēles vai pievieno savas.</span>
                            </div>
                            <span class="filter-count" data-setup-count>8 spēles</span>
                        </div>
                        <div class="add-game-form">
                            <input type="text" placeholder="Piemēram, Elden Ring" aria-label="Jaunas spēles nosaukums" data-game-name-input>
                            <button class="button button-secondary" type="button" data-add-game>Pievienot spēli</button>
                        </div>
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

    <script>
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
        const searchGamesInput = document.querySelector('[data-search-games]');
        const tournamentStatus = document.querySelector('[data-tournament-status]');
        const winnerDefault = document.querySelector('[data-winner-default]');
        const winnerResult = document.querySelector('[data-winner-result]');
        const winnerImage = document.querySelector('[data-winner-image]');
        const winnerName = document.querySelector('[data-winner-name]');
        const sideResetButton = document.querySelector('[data-side-reset]');
        let candidates = [
            { name: 'The Witcher 3', genre: 'RPG', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg' },
            { name: 'Counter-Strike 2', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/730/header.jpg' },
            { name: 'Stardew Valley', genre: 'RPG', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/413150/header.jpg' },
            { name: 'Hades', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1145360/header.jpg' },
            { name: 'Portal 2', genre: 'Action', style: 'Co-op', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/620/header.jpg' },
            { name: 'Red Dead Redemption 2', genre: 'Action', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1174180/header.jpg' },
            { name: 'Terraria', genre: 'RPG', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/105600/header.jpg' },
            { name: 'Skyrim', genre: 'RPG', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/489830/header.jpg' },
        ];

        const randomGamePool = [
            { name: 'Elden Ring', genre: 'RPG', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg' },
            { name: 'Cyberpunk 2077', genre: 'RPG', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg' },
            { name: 'Baldur\'s Gate 3', genre: 'RPG', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1086940/header.jpg' },
            { name: 'Hollow Knight', genre: 'Indie', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg' },
            { name: 'Dead Cells', genre: 'Action', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/588650/header.jpg' },
            { name: 'Risk of Rain 2', genre: 'Action', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/632360/header.jpg' },
            { name: 'Sea of Thieves', genre: 'Co-op', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1172620/header.jpg' },
            { name: 'Deep Rock Galactic', genre: 'Co-op', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/548430/header.jpg' },
            { name: 'Civilization VI', genre: 'Strategy', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/289070/header.jpg' },
            { name: 'Slay the Spire', genre: 'Strategy', style: 'Indie', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/646570/header.jpg' },
            { name: 'The Sims 4', genre: 'Simulation', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1222670/header.jpg' },
            { name: 'Euro Truck Simulator 2', genre: 'Simulation', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/227300/header.jpg' },
            { name: 'Trackmania', genre: 'Racing', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2225070/header.jpg' },
            { name: 'Forza Horizon 5', genre: 'Racing', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg' },
            { name: 'Apex Legends', genre: 'Action', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1172470/header.jpg' },
            { name: 'Subnautica', genre: 'Indie', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/264710/header.jpg' },
        ];
        let usedRandomGames = [];

        let tournamentState = {
            round: 0,
            winners: [],
            champion: null,
            completedRounds: [],
        };

        const rounds = [
            { name: 'Ceturtdaļfināli', games: candidates },
            { name: 'Pusfināli', games: [] },
            { name: 'Fināls', games: [] },
        ];

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
            return encodeURIComponent(game.name);
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
                shuffleGamesButton.disabled = isRunning;
            }
            if (randomTournamentGamesButton) {
                randomTournamentGamesButton.disabled = isRunning;
            }
            if (startTournamentButton) {
                startTournamentButton.disabled = isRunning;
            }
        }

        function advanceByes(round) {
            const automaticWinners = createPairings(round.games)
                .filter(([first, second]) => first.isBye || second.isBye)
                .map(([first, second]) => first.isBye ? second : first);

            automaticWinners.forEach((game) => {
                if (!tournamentState.winners.some((winner) => winner.name === game.name)) {
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
            const query = searchGamesInput ? searchGamesInput.value.trim().toLowerCase() : '';
            const visibleGames = candidates
                .map((game, index) => ({ game, index }))
                .filter(({ game }) => game.name.toLowerCase().includes(query))
                .sort((first, second) => first.index - second.index);

            customGameList.innerHTML = visibleGames.length
                ? visibleGames.map(({ game, index }) => `
                    <article class="custom-game-card">
                        <img src="${escapeHtml(game.image)}" alt="${escapeHtml(game.name)} spēles attēls">
                        <div><strong>${escapeHtml(game.name)}</strong><span>${escapeHtml(game.genre)} · ${escapeHtml(game.style)}</span></div>
                        <button type="button" aria-label="Noņemt ${escapeHtml(game.name)}" data-remove-game="${index}">×</button>
                    </article>
                `).join('')
                : '<p class="game-search-empty">Spēle netika atrasta.</p>';
        }

        function renderMatch(pair, matchIndex) {
            const [first, second] = pair;

            if (first.isBye || second.isBye) {
                const activeGame = first.isBye ? second : first;
                return `
                    <article class="bracket-match bracket-match--bye">
                        <div class="bracket-match-topline"><span class="bracket-match-label">Mačs ${matchIndex + 1}</span><span class="bracket-confidence">Brīva vieta</span></div>
                        <button class="bracket-contender is-winner" type="button" data-bracket-winner="${gameKey(activeGame)}">
                            <img src="${escapeHtml(activeGame.image)}" alt="">
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
                        <img src="${escapeHtml(first.image)}" alt="">
                        <span><i>${escapeHtml(first.genre)}</i>${escapeHtml(first.name)}</span>
                    </button>
                    <div class="bracket-versus">VS</div>
                    <button class="bracket-contender" type="button" data-bracket-winner="${gameKey(second)}">
                        <img src="${escapeHtml(second.image)}" alt="">
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
                <div class="bracket-progress" aria-label="Turnīra progress">
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
            if (tournamentState.winners.some((game) => game.name === selectedWinner.name)) {
                return;
            }
            tournamentState.winners.push(selectedWinner);
            const currentRound = rounds[tournamentState.round - 1];
            const expectedWinners = currentRound.games.length / 2;
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
            rounds[tournamentState.round].games = tournamentState.winners;
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
                rounds[0].games = getBracketPool(candidates);
                rounds[1].games = [];
                rounds[2].games = [];
                if (setup) {
                    setup.hidden = true;
                }
                setTournamentStatus('Turnīrs sākts. Izvēlies vienu spēli katrā pārī.');
                renderTournament();
            });
        }

        if (shuffleGamesButton) {
            shuffleGamesButton.addEventListener('click', () => {
                candidates.sort(() => Math.random() - 0.5);
                renderSetup();
            });
        }

        if (randomTournamentGamesButton) {
            randomTournamentGamesButton.addEventListener('click', () => {
                let availableGames = randomGamePool.filter((game) => !usedRandomGames.includes(game.name));
                if (availableGames.length < 8) {
                    usedRandomGames = [];
                    availableGames = [...randomGamePool];
                }

                availableGames.sort(() => Math.random() - 0.5);
                const selectedGames = availableGames.slice(0, 8);
                usedRandomGames.push(...selectedGames.map((game) => game.name));
                candidates = selectedGames;
                tournamentState = { round: 0, winners: [], champion: null, completedRounds: [] };
                clearChampion();
                if (setup) {
                    setup.hidden = false;
                }
                renderSetup();
                renderTournament();
                setTournamentStatus('Ielādētas 8 jaunas random spēles. Pārbaudi sarakstu un sāc turnīru.');
            });
        }

        if (resetSelectionButton) {
            resetSelectionButton.addEventListener('click', () => {
                tournamentState = { round: 0, winners: [], champion: null, completedRounds: [] };
                clearChampion();
                rounds[1].games = [];
                rounds[2].games = [];
                if (setup) {
                    setup.hidden = false;
                }
                setTournamentStatus('Jauns turnīrs gatavs. Vari mainīt spēļu sarakstu.');
                renderTournament();
            });
        }

        if (addGameButton) {
            addGameButton.addEventListener('click', () => {
                const name = gameNameInput.value.trim();
                if (!name || candidates.some((game) => game.name.toLowerCase() === name.toLowerCase()) || candidates.length >= 16) {
                    return;
                }

                candidates.push({
                    name,
                    genre: 'Custom',
                    style: 'Mana izvēle',
                    image: `https://placehold.co/640x360/15203a/b9f7cf?text=${encodeURIComponent(name)}`,
                });
                gameNameInput.value = '';
                renderSetup();
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
                renderSetup();
            });
        }

        renderSetup();
        renderTournament();
    </script>
</body>
</html>
