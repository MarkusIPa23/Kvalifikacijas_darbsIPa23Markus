<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Atbilstības rādītāji</title>
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
                <p class="eyebrow">ATBILSTĪBAS RĀDĪTĀJI</p>
                <h1>RAWG spēļu vērtējumi.</h1>
                <p>Pārlūko RAWG vērtējumus vai atrodi konkrētu spēli pēc nosaukuma.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>RAWG vērtējums</h2>
                            <p>Kataloga vērtējums un spēles informācija</p>
                        </div>
                        <span class="filter-count" data-score-count>Notiek ielāde</span>
                    </div>

                    <form class="future-game-search" data-score-search-form>
                        <label for="score-game-search">Meklē spēli, ko pievienot sarakstam</label>
                        <div class="future-game-search-controls">
                            <input id="score-game-search" type="search" maxlength="100" placeholder="Meklē pēc spēles nosaukuma" data-score-search>
                            <button class="button button-secondary" type="submit">Meklēt</button>
                            <button class="future-search-clear" type="button" data-score-search-clear hidden>Notīrīt</button>
                        </div>
                    </form>
                    <div class="score-list" data-score-list aria-label="Spēles pēc RAWG vērtējuma"></div>
                    <p class="hybrid-search-status" data-score-status role="status">Notiek spēļu ielāde no kataloga...</p>
                </div>

                <aside class="side-tip">
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div class="mini-label">Mērījumi</div>
                    <h2>Vērtējums no RAWG</h2>
                    <p>Vērtējums parāda RAWG kopienas novērtējumu, nevis personalizētu atbilstību.</p>
                </aside>
            </div>
        </main>
    </div>

    @include('future.partials.games-api')
    <script>
        const scoreList = document.querySelector('[data-score-list]');
        const scoreCount = document.querySelector('[data-score-count]');
        const scoreStatus = document.querySelector('[data-score-status]');
        const scoreSearchForm = document.querySelector('[data-score-search-form]');
        const scoreSearchInput = document.querySelector('[data-score-search]');
        const scoreSearchClear = document.querySelector('[data-score-search-clear]');
        let scoreRequestId = 0;
        const escapeHtml = (value) => String(value).replace(/[&<>"']/g, (character) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;',
        }[character]));

        async function loadScoreGames(search = '') {
            const requestId = ++scoreRequestId;
            scoreStatus.textContent = search ? `Meklē “${search}” RAWG katalogā...` : 'Notiek spēļu ielāde no RAWG kataloga...';
            scoreList.innerHTML = '';
            scoreSearchClear.hidden = !search;

            try {
                const games = await FutureGamesApi.list({ page_size: 40, ordering: '-rating', ...(search ? { search } : {}) });
                if (requestId !== scoreRequestId) {
                    return;
                }

                scoreCount.textContent = `${games.length} ${search ? 'atrastas spēles' : 'rezultāti'}`;
                scoreStatus.textContent = games.length
                    ? ''
                    : search ? 'RAWG katalogā spēle netika atrasta.' : 'Katalogā spēles netika atrastas.';
                scoreList.innerHTML = games.map((game) => {
                    const rating = Number(game.rating);
                    const score = Number.isFinite(rating) ? Math.max(0, Math.min(5, rating)) : 0;

                    return `
                        <div class="score-row${game.thumbnail ? ' has-cover' : ''}">
                            ${game.thumbnail ? `<a class="score-art" href="${FutureGamesApi.detailUrl(game.id)}" tabindex="-1" aria-hidden="true"><img src="${escapeHtml(game.thumbnail)}" alt="" loading="lazy" decoding="async"></a>` : ''}
                            <div>
                                <strong><a href="${FutureGamesApi.detailUrl(game.id)}">${escapeHtml(game.title)}</a></strong>
                                <span>${escapeHtml(game.genre)} · ${escapeHtml(game.platform)}</span>
                            </div>
                            <div class="score-line" role="img" aria-label="${score ? `${score.toFixed(1)} no 5` : 'RAWG vērtējuma nav'}"><span style="width: ${score * 20}%"></span></div>
                            <em>${score ? `${score.toFixed(1)}/5` : 'Nav vērtējuma'}</em>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                if (requestId !== scoreRequestId || error.name === 'AbortError') {
                    return;
                }

                scoreCount.textContent = 'Nav pieejams';
                scoreStatus.textContent = error.message;
                scoreList.innerHTML = '<p class="empty-state">Spēles pašlaik nav pieejamas.</p>';
            }
        }

        scoreSearchForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const search = scoreSearchInput.value.trim();
            loadScoreGames(search);
        });

        scoreSearchClear.addEventListener('click', () => {
            scoreSearchInput.value = '';
            scoreSearchClear.hidden = true;
            loadScoreGames();
            scoreSearchInput.focus();
        });

        loadScoreGames();
    </script>
</body>
</html>
