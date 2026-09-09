<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nejauša spēle — Game to Top</title>
    <style>
        :root { --ink: #15203a; --muted: #65718a; --purple: #6d4aff; --bg: #f5f7fc; --line: #dfe5ee; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: radial-gradient(circle at 88% 5%, #e5dfff 0, transparent 26rem), var(--bg); font-family: Arial, sans-serif; }
        .container { width: min(100% - 40px, 1000px); margin: 0 auto; padding: 48px 0 72px; }
        .back { display: inline-flex; margin-bottom: 46px; color: #56637c; font-size: .92rem; font-weight: bold; text-decoration: none; }
        .back:hover { color: var(--purple); }
        .eyebrow { margin: 0 0 12px; color: var(--purple); font-size: .75rem; font-weight: bold; letter-spacing: .12em; }
        h1 { max-width: 640px; margin: 0 0 14px; font-size: clamp(2.5rem, 7vw, 4.4rem); letter-spacing: -.06em; line-height: 1; }
        .intro { max-width: 630px; margin: 0 0 38px; color: var(--muted); font-size: 1.08rem; line-height: 1.65; }
        .filters { padding: 28px; border: 1px solid var(--line); border-radius: 20px; background: #fff; box-shadow: 0 18px 45px rgba(35, 49, 78, .1); }
        .filter-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .search-field { margin-bottom: 20px; }
        label { display: block; margin-bottom: 9px; color: #3b4860; font-size: .82rem; font-weight: bold; }
        input, select { width: 100%; height: 47px; padding: 0 12px; border: 1px solid #d9e0eb; border-radius: 10px; color: var(--ink); background: #fbfcfe; font-size: .95rem; }
        input:focus, select:focus { outline: 3px solid #ded7ff; border-color: var(--purple); }
        button { width: 100%; min-height: 52px; margin-top: 25px; border: 0; border-radius: 11px; color: #fff; background: var(--purple); box-shadow: 0 12px 23px rgba(109, 74, 255, .28); font-size: 1rem; font-weight: bold; cursor: pointer; transition: background .2s, transform .2s; }
        button:hover { background: #4f2bdf; transform: translateY(-2px); }
        .result { display: grid; grid-template-columns: 285px 1fr; gap: 0; margin-top: 30px; overflow: hidden; border: 1px solid var(--line); border-radius: 20px; background: #fff; box-shadow: 0 18px 45px rgba(35, 49, 78, .1); }
        .cover { width: 100%; height: 100%; min-height: 260px; object-fit: cover; background: #e7eaf2; }
        .game-info { padding: 32px; }
        .result-label { margin: 0 0 13px; color: var(--purple); font-size: .72rem; font-weight: bold; letter-spacing: .12em; }
        h2 { margin: 0 0 13px; font-size: clamp(1.75rem, 4vw, 2.45rem); letter-spacing: -.045em; }
        .description { max-width: 560px; color: var(--muted); line-height: 1.6; }
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 20px 0 24px; }
        .tags span { padding: 7px 10px; border-radius: 7px; color: #43516a; background: #eef1f7; font-size: .78rem; font-weight: bold; }
        .play-link { display: inline-block; padding: 12px 17px; border-radius: 10px; color: var(--purple); background: #f0edff; font-weight: bold; text-decoration: none; }
        .play-link:hover { color: #fff; background: var(--purple); }
        .search-results { margin-top: 30px; }
        .search-result-title { margin-bottom: 22px; font-size: 1.5rem; }
        .game-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .search-card { overflow: hidden; border: 1px solid var(--line); border-radius: 16px; background: #fff; box-shadow: 0 12px 30px rgba(35, 49, 78, .08); }
        .search-card .cover { height: 150px; min-height: 0; }
        .search-card-info { padding: 18px; }
        .search-card h3 { margin: 0 0 9px; font-size: 1.1rem; }
        .search-card p { min-height: 42px; margin: 0 0 16px; color: var(--muted); font-size: .86rem; line-height: 1.5; }
        .search-card .tags { margin: 0 0 17px; }
        .search-card .play-link { padding: 10px 13px; font-size: .85rem; }
        .notice { margin-top: 30px; padding: 22px; border: 1px solid #f0d997; border-radius: 14px; color: #705622; background: #fff9e9; line-height: 1.55; }
        .source { margin: 25px 0 0; color: #778298; font-size: .8rem; text-align: right; }
        .source a { color: inherit; }
        @media (max-width: 700px) { .container { width: min(100% - 32px, 1000px); padding-top: 30px; } .filter-grid, .result, .game-grid { grid-template-columns: 1fr; } .cover { max-height: 230px; min-height: 0; } .game-info { padding: 25px; } }
    </style>
</head>
<body>
    <main class="container">
        <a class="back" href="{{ url('/') }}">← Atpakaļ uz sākumu</a>

        <p class="eyebrow">BEZMAKSAS SPĒĻU IZLASE</p>
        <h1>Ko spēlēsim šodien?</h1>
        <p class="intro">Izvēlies kritērijus, un Game to Top atradīs nejaušu bezmaksas spēli no FreeToGame kataloga.</p>

        <form class="filters" action="{{ url('/random') }}" method="GET">
            <div class="search-field" id="meklet">
                <label for="search">Meklēt pēc spēles nosaukuma</label>
                <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Piemēram, Warframe vai Fortnite">
            </div>
            <div class="filter-grid">
                <div>
                    <label for="genre">Žanrs</label>
                    <select id="genre" name="genre">
                        <option value="">Visi žanri</option>
                        <option value="mmorpg" @selected(($filters['genre'] ?? '') === 'mmorpg')>MMORPG</option>
                        <option value="shooter" @selected(($filters['genre'] ?? '') === 'shooter')>Shooter</option>
                        <option value="moba" @selected(($filters['genre'] ?? '') === 'moba')>MOBA</option>
                        <option value="strategy" @selected(($filters['genre'] ?? '') === 'strategy')>Strategy</option>
                        <option value="racing" @selected(($filters['genre'] ?? '') === 'racing')>Racing</option>
                        <option value="sports" @selected(($filters['genre'] ?? '') === 'sports')>Sports</option>
                        <option value="fighting" @selected(($filters['genre'] ?? '') === 'fighting')>Fighting</option>
                    </select>
                </div>
                <div>
                    <label for="platform">Platforma</label>
                    <select id="platform" name="platform">
                        <option value="">Visas platformas</option>
                        <option value="pc" @selected(($filters['platform'] ?? '') === 'pc')>PC (Windows)</option>
                        <option value="browser" @selected(($filters['platform'] ?? '') === 'browser')>Pārlūks</option>
                    </select>
                </div>
                <div>
                    <label for="year">Izdošanas periods</label>
                    <select id="year" name="year">
                        <option value="">Visi gadi</option>
                        <option value="2010-2015" @selected(($filters['year'] ?? '') === '2010-2015')>2010–2015</option>
                        <option value="2016-2020" @selected(($filters['year'] ?? '') === '2016-2020')>2016–2020</option>
                        <option value="2021-2026" @selected(($filters['year'] ?? '') === '2021-2026')>2021–2026</option>
                    </select>
                </div>
            </div>
            <button type="submit">Meklēt spēles / izvēlēties nejauši</button>
        </form>

        @if ($isSearching && $searchResults->isNotEmpty())
            <section class="search-results" aria-live="polite" aria-labelledby="search-results-title">
                <p class="result-label">MEKLĒŠANAS REZULTĀTI</p>
                <h2 class="search-result-title" id="search-results-title">Atrastas {{ $resultsCount }} spēles pēc “{{ $filters['search'] }}”</h2>
                <div class="game-grid">
                    @foreach ($searchResults as $searchGame)
                        <article class="search-card">
                            @if (filled($searchGame['thumbnail'] ?? null))
                                <img class="cover" src="{{ $searchGame['thumbnail'] }}" alt="{{ $searchGame['title'] }} spēles attēls">
                            @endif
                            <div class="search-card-info">
                                <h3>{{ $searchGame['title'] }}</h3>
                                <p>{{ $searchGame['short_description'] }}</p>
                                <div class="tags"><span>{{ $searchGame['genre'] }}</span><span>{{ $searchGame['platform'] }}</span></div>
                                <a class="play-link" href="{{ $searchGame['game_url'] }}" target="_blank" rel="noopener noreferrer">Apskatīt spēli →</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @elseif ($game)
            <article class="result" aria-labelledby="game-title">
                @if (filled($game['thumbnail'] ?? null))
                    <img class="cover" src="{{ $game['thumbnail'] }}" alt="{{ $game['title'] }} spēles attēls">
                @endif
                <div class="game-info">
                    <p class="result-label">TAVS IETEIKUMS</p>
                    <h2 id="game-title">{{ $game['title'] }}</h2>
                    <p class="description">{{ $game['short_description'] }}</p>
                    <div class="tags">
                        <span>{{ $game['genre'] }}</span>
                        <span>{{ $game['platform'] }}</span>
                        <span>{{ $game['release_date'] }}</span>
                    </div>
                    <a class="play-link" href="{{ $game['game_url'] }}" target="_blank" rel="noopener noreferrer">Apskatīt spēli →</a>
                </div>
            </article>
        @elseif ($error)
            <p class="notice">{{ $error }}</p>
        @endif

        <p class="source">Spēļu dati: <a href="https://www.freetogame.com/" target="_blank" rel="noopener noreferrer">FreeToGame.com</a></p>
    </main>
</body>
</html>
