<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game to Top | Salīdzināšana</title>
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
                <p class="eyebrow">SALĪDZINĀŠANA</p>
                <h1>Divu spēļu salīdzinājums.</h1>
                <p>Salīdzini divas spēles, lai ātri redzētu, kura labāk iekļaujas tavā gaumē un vēlmēs.</p>
            </section>

            <div class="selection-layout">
                <div class="filter-panel">
                    <div class="panel-title">
                        <div>
                            <h2>Salīdzinājuma panelis</h2>
                            <p>Autors izvēlētos kandidātus</p>
                        </div>
                        <span class="filter-count">2 spēles</span>
                    </div>

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

                    <div class="comparison-grid" data-comparison></div>
                </div>

                <aside class="side-tip comparison-insight" data-comparison-insight>
                    <div class="sparkle" aria-hidden="true">✦</div>
                    <div data-insight-default>
                        <div class="mini-label">Analīze</div>
                        <h2>Skatīšanās pēc parametriem</h2>
                        <p>Izvēlies divas spēles, un šeit parādīsies ātrs, saprotams salīdzināšanas spriedums.</p>
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

    <script>
        const prototypeGames = [
            { name: 'The Witcher 3', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg' },
            { name: 'Counter-Strike 2', genre: 'Action', platform: 'PC', time: 'Short', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/730/header.jpg' },
            { name: 'Stardew Valley', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/413150/header.jpg' },
            { name: 'Hades', genre: 'Action', platform: 'PC', time: 'Medium', style: 'Competitive', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1145360/header.jpg' },
            { name: 'Portal 2', genre: 'Action', platform: 'PC', time: 'Short', style: 'Co-op', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/620/header.jpg' },
            { name: 'Skyrim', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/489830/header.jpg' },
            { name: 'Elden Ring', genre: 'RPG', platform: 'PC', time: 'Long', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg' },
            { name: 'It Takes Two', genre: 'Co-op', platform: 'Console', time: 'Medium', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1426210/header.jpg' },
            { name: 'Civilization VI', genre: 'Strategy', platform: 'PC', time: 'Long', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/289070/header.jpg' },
            { name: 'Forza Horizon 5', genre: 'Racing', platform: 'Console', time: 'Medium', style: 'Open World', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg' },
            { name: 'Hollow Knight', genre: 'Indie', platform: 'PC', time: 'Medium', style: 'Story', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg' },
            { name: 'Minecraft', genre: 'RPG', platform: 'Mobile', time: 'Long', style: 'Relaxed', image: 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1672970/header.jpg' },
        ];

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

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, (character) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;',
            }[character]));
        }

        function renderSelectors() {
            const options = prototypeGames.map((game) => `<option value="${escapeHtml(game.name)}">${escapeHtml(game.name)}</option>`).join('');
            firstSelect.innerHTML = options;
            secondSelect.innerHTML = options;
            secondSelect.selectedIndex = 1;
        }

        function renderComparison() {
            const first = prototypeGames.find((game) => game.name === firstSelect.value);
            const second = prototypeGames.find((game) => game.name === secondSelect.value);
            if (!first || !second) {
                return;
            }

            const sharedTraits = [
                first.genre === second.genre ? 'žanrs' : null,
                first.platform === second.platform ? 'platforma' : null,
                first.time === second.time ? 'spēles ilgums' : null,
                first.style === second.style ? 'stils' : null,
            ].filter(Boolean);
            const difference = first.genre !== second.genre
                ? `žanrs: ${first.genre} pret ${second.genre}`
                : first.style !== second.style
                    ? `stils: ${first.style} pret ${second.style}`
                    : first.time !== second.time
                        ? `ilgums: ${first.time} pret ${second.time}`
                        : 'abas spēles ir ļoti līdzīgas';

            if (insightDefault && insightResult && sharedCount && insightTitle && insightCopy && insightTags) {
                insightDefault.hidden = true;
                insightResult.hidden = false;
                sharedCount.textContent = sharedTraits.length;
                insightTitle.textContent = sharedTraits.length >= 3 ? 'Ļoti līdzīgs duets' : sharedTraits.length ? 'Interesants kontrasts' : 'Divas pilnīgi atšķirīgas izvēles';
                insightCopy.textContent = `${first.name} un ${second.name} galvenā atšķirība: ${difference}.`;
                insightTags.innerHTML = sharedTraits.length
                    ? sharedTraits.map((trait) => `<span>${escapeHtml(trait)}</span>`).join('')
                    : '<span>Nav kopīgu parametru</span>';
            }

            comparison.innerHTML = [first, second].map((game) => `
                <article class="comparison-card">
                    <img class="comparison-card-image" src="${escapeHtml(game.image)}" alt="${escapeHtml(game.name)} spēles attēls">
                    <h4>${escapeHtml(game.name)}</h4>
                    <div class="comparison-stat"><span>Žanrs</span><strong>${escapeHtml(game.genre)}</strong></div>
                    <div class="comparison-stat"><span>Platforma</span><strong>${escapeHtml(game.platform)}</strong></div>
                    <div class="comparison-stat"><span>Garums</span><strong>${escapeHtml(game.time)}</strong></div>
                    <div class="comparison-stat"><span>Stils</span><strong>${escapeHtml(game.style)}</strong></div>
                </article>
            `).join('') + `
                <div class="comparison-result-note">
                    <strong>${sharedTraits.length ? 'Kopīgais starp spēlēm' : 'Atšķirīgas spēles'}</strong>
                    <span>${sharedTraits.length ? sharedTraits.join(' · ') : 'Šīm spēlēm nav vienādu pamatparametru.'}</span>
                </div>
            `;
        }

        runComparisonButton.addEventListener('click', renderComparison);
        renderSelectors();
        renderComparison();
    </script>
</body>
</html>
