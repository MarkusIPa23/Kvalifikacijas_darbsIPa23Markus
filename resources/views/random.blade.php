<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nejauša spēle — Game to Top</title>
    @vite(['resources/css/store-wallpaper.css'])
    <style>
        :root { --ink: #15203a; --muted: #65718a; --purple: #6d4aff; --purple-dark: #4f2bdf; --bg: #f5f7fc; --line: #dfe5ee; --mint: #c7f8d6; --surface: #fff; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: radial-gradient(circle at 88% 5%, #e5dfff 0, transparent 26rem), linear-gradient(135deg, #f5f7fc 0%, #f8fbff 52%, #eef5ff 100%); font-family: "Trebuchet MS", "Segoe UI", sans-serif; }
        .container { width: min(100% - 40px, 1060px); margin: 0 auto; padding: 28px 0 72px; }
        header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 72px; }
        .brand, .search-link, .home-link, .new-game { color: inherit; font-weight: bold; text-decoration: none; }
        .brand { display: inline-flex; align-items: center; gap: 9px; font-size: 1.08rem; letter-spacing: -.03em; }
        .brand::before { content: '✦'; display: grid; width: 29px; height: 29px; place-items: center; border-radius: 9px; color: #fff; background: var(--purple); box-shadow: 0 7px 16px rgba(109, 74, 255, .25); font-size: .9rem; }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .home-link { color: var(--muted); font-size: .86rem; }
        .home-link:hover { color: var(--purple); }
        .search-link { padding: 10px 14px; border: 1px solid #d8d0ff; border-radius: 9px; color: var(--purple); background: #f7f5ff; font-size: .88rem; }
        .search-link:hover { border-color: var(--purple); }
        .eyebrow { margin: 0 0 12px; color: var(--purple); font-size: .75rem; font-weight: bold; letter-spacing: .12em; }
        h1 { max-width: 670px; margin: 0 0 15px; font-size: clamp(2.65rem, 7vw, 4.7rem); letter-spacing: -.065em; line-height: 1; }
        .intro { max-width: 590px; margin: 0 0 26px; color: var(--muted); font-size: 1.08rem; line-height: 1.65; }
        .filters { margin-bottom: 28px; padding: 22px; border: 1px solid rgba(109, 74, 255, .14); border-radius: 18px; background: rgba(255,255,255,.86); box-shadow: 0 16px 38px rgba(35, 49, 78, .07); }
        .filters-heading { display: flex; align-items: end; justify-content: space-between; gap: 18px; margin-bottom: 17px; }
        .filters-heading h2 { margin: 0; font-size: 1.05rem; letter-spacing: -.03em; }
        .filters-heading p { margin: 0; color: var(--muted); font-size: .78rem; }
        .filter-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
        .filter-grid label { display: block; margin-bottom: 7px; color: var(--ink); font-size: .8rem; font-weight: bold; }
        .filter-grid select { width: 100%; min-height: 44px; padding: 0 11px; border: 1px solid #d9e0eb; border-radius: 9px; color: var(--ink); background: #fff; font: inherit; }
        .filter-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-top: 16px; }
        .filter-actions button, .filter-reset { min-height: 42px; padding: 0 15px; border-radius: 9px; font: inherit; font-weight: bold; }
        .filter-actions button { border: 0; color: #fff; background: var(--purple); cursor: pointer; }
        .filter-actions button:hover { background: var(--purple-dark); }
        .filter-reset { display: inline-flex; align-items: center; border: 1px solid var(--line); color: var(--muted); background: #fff; }
        .filter-grid select:focus, .filter-actions button:focus-visible, .filter-reset:focus-visible, .search-link:focus-visible, .home-link:focus-visible, .action:focus-visible, .favorite-button:focus-visible { outline: 3px solid rgba(109, 74, 255, .24); outline-offset: 2px; }
        .active-filters { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin: -12px 0 24px; color: var(--muted); font-size: .78rem; }
        .active-filters strong { color: var(--ink); }
        .active-filters span { padding: 6px 9px; border-radius: 999px; color: var(--purple-dark); background: #eeeaff; font-weight: bold; }
        .result { display: grid; grid-template-columns: 355px 1fr; overflow: hidden; border: 1px solid var(--line); border-radius: 22px; background: var(--surface); box-shadow: 0 24px 55px rgba(35, 49, 78, .13); }
        .cover-wrap { position: relative; min-height: 360px; overflow: hidden; background: #e7eaf2; }
        .cover { width: 100%; height: 100%; min-height: 360px; object-fit: cover; transition: transform .45s ease; }
        .result:hover .cover { transform: scale(1.035); }
        .cover-badge { position: absolute; left: 18px; bottom: 18px; padding: 7px 10px; border-radius: 8px; color: var(--ink); background: var(--mint); font-size: .68rem; font-weight: bold; letter-spacing: .08em; }
        .game-info { padding: 36px; }
        .result-label { margin: 0 0 13px; color: var(--purple); font-size: .72rem; font-weight: bold; letter-spacing: .12em; }
        h2 { margin: 0 0 13px; font-size: clamp(1.9rem, 4vw, 2.65rem); letter-spacing: -.045em; }
        .description { max-width: 520px; margin-bottom: 0; color: var(--muted); line-height: 1.65; }
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 20px 0 24px; }
        .tags span { padding: 7px 10px; border: 1px solid #e1e7f0; border-radius: 7px; color: #43516a; background: #f5f7fb; font-size: .78rem; font-weight: bold; }
        .actions { display: flex; flex-wrap: wrap; gap: 11px; align-items: center; }
        .actions form { margin: 0; }
        .action { display: inline-block; padding: 12px 17px; border-radius: 10px; font-weight: bold; text-decoration: none; }
        .game-link { color: var(--purple); background: #f0edff; }
        .new-game { color: #fff; background: var(--purple); box-shadow: 0 10px 20px rgba(109, 74, 255, .25); }
        .game-link:hover, .new-game:hover { background: var(--purple-dark); color: #fff; }
        .favorite-button { display: inline-block; padding: 12px 17px; border: 0; border-radius: 10px; color: #8a6410; background: #fff8df; font: inherit; font-weight: bold; cursor: pointer; }
        .favorite-button.is-favorite { color: var(--purple); background: #f0edff; }
        .rating-panel { margin-top: 20px; padding: 16px; border: 1px solid #ebe7ff; border-radius: 12px; background: #fbfaff; }
        .rating-summary { margin: 0 0 10px; font-weight: bold; }
        .rating-form { display: flex; align-items: center; flex-wrap: wrap; gap: 9px; }
        .rating-form label { color: var(--muted); font-size: .85rem; font-weight: bold; }
        .rating-form select { min-height: 38px; padding: 0 8px; border: 1px solid #d9e0eb; border-radius: 8px; color: var(--ink); background: #fff; font: inherit; }
        .rating-form button { min-height: 38px; padding: 0 13px; border: 0; border-radius: 8px; color: #fff; background: var(--purple); font: inherit; font-weight: bold; cursor: pointer; }
        .rating-login { margin: 0; color: var(--muted); font-size: .85rem; }
        .comment-panel { margin-top: 22px; padding: 22px; border: 1px solid var(--line); border-radius: 16px; background: #fff; box-shadow: 0 14px 30px rgba(35, 49, 78, .06); }
        .comment-panel h3 { margin: 0 0 16px; font-size: 1.1rem; }
        .comment-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
        .comment-item { padding: 12px 14px; border: 1px solid #eef1f7; border-radius: 10px; background: #f9fafc; }
        .comment-item strong { display: block; margin-bottom: 4px; color: var(--purple); font-size: .76rem; }
        .comment-item p { margin: 0; color: var(--ink); line-height: 1.5; }
        .comment-tools { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 8px; }
        .comment-edit { flex: 1 1 100%; }
        .comment-edit summary { color: var(--purple); font-size: .78rem; font-weight: bold; cursor: pointer; }
        .comment-edit-form { display: grid; gap: 8px; margin-top: 8px; }
        .comment-edit-form textarea { width: 100%; min-height: 65px; padding: 9px 10px; border: 1px solid var(--line); border-radius: 8px; font: inherit; resize: vertical; }
        .comment-tools button { min-height: 32px; padding: 0 10px; border: 1px solid var(--line); border-radius: 8px; color: var(--ink); background: #fff; font-size: .75rem; cursor: pointer; }
        .comment-tools .comment-delete-button { color: #b42318; border-color: #f1c6c3; background: #fff7f6; }
        .comment-form { display: flex; flex-direction: column; gap: 8px; }
        .comment-form textarea { width: 100%; min-height: 80px; padding: 10px 12px; border: 1px solid #dfe5ee; border-radius: 10px; background: #fff; color: var(--ink); resize: vertical; font: inherit; }
        .comment-form button { align-self: flex-start; padding: 10px 16px; border: 0; border-radius: 10px; color: #fff; background: var(--purple); font-weight: bold; cursor: pointer; }
        .comment-empty, .comment-login { color: var(--muted); font-size: .82rem; }
        .notice { padding: 22px; border: 1px solid #f0d997; border-radius: 14px; color: #705622; background: #fff9e9; line-height: 1.55; }
        .source { margin: 25px 0 0; color: #778298; font-size: .8rem; text-align: right; }
        .source a { color: inherit; }
        @media (max-width: 800px) { .filter-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .result { grid-template-columns: 285px 1fr; } }
        @media (max-width: 700px) { .container { width: min(100% - 32px, 960px); } header { align-items: flex-start; margin-bottom: 52px; } .header-actions { align-items: flex-end; flex-direction: column; gap: 7px; } .filters-heading { align-items: flex-start; flex-direction: column; gap: 5px; } .filter-grid { grid-template-columns: 1fr; } .result { grid-template-columns: 1fr; } .cover-wrap { min-height: 245px; } .cover { max-height: 245px; min-height: 245px; } .game-info { padding: 25px; } .actions { align-items: stretch; flex-direction: column; } .action, .favorite-button { text-align: center; } .actions form { width: 100%; } .favorite-button { width: 100%; } }
    </style>
</head>
<body>
    @include('future.partials.store-wallpaper')
    <main class="container">
        <header>
            <a class="brand" href="{{ route('home') }}">Game to Top</a>
            <div class="header-actions">
                <a class="home-link" href="{{ route('home') }}">Sākums</a>
                <a class="search-link" href="{{ route('games.search') }}">Meklēt spēles</a>
            </div>
        </header>

        <p class="eyebrow">NEJAUŠS IETEIKUMS</p>
        <h1>Atrodi ko negaidītu.</h1>
        <p class="intro">Nosaki noskaņu, platformu vai laikmetu, un mēs atradīsim spēli, kuru šodien tiešām gribas izmēģināt.</p>

        <form class="filters" action="{{ route('games.random') }}" method="GET">
            <div class="filters-heading">
                <h2>Pielāgo savu ieteikumu</h2>
                <p>Jo precīzāki filtri, jo trāpīgāks rezultāts.</p>
            </div>
            <div class="filter-grid">
                <div>
                    <label for="random-genre">Žanrs</label>
                    <select id="random-genre" name="genre">
                        <option value="">Visi žanri</option>
                        @foreach ($genres as $slug => $name)
                            <option value="{{ $slug }}" @selected(($filters['genre'] ?? '') === $slug)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="random-platform">Platforma</label>
                    <select id="random-platform" name="platform">
                        <option value="">Visas platformas</option>
                        @foreach ($platforms as $slug => $name)
                            <option value="{{ $slug }}" @selected(($filters['platform'] ?? '') === $slug)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="random-year">Izdošanas gads</label>
                    <select id="random-year" name="year">
                        <option value="">Jebkurš gads</option>
                        @for ($year = now()->year + 1; $year >= 1980; $year--)
                            <option value="{{ $year }}" @selected((string) ($filters['year'] ?? '') === (string) $year)>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="random-ordering">Prioritāte</label>
                    <select id="random-ordering" name="ordering">
                        @foreach ($orderings as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['ordering'] ?? '-added') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="filter-actions">
                <button type="submit">Izvēlēties spēli</button>
                <a class="filter-reset" href="{{ route('games.random') }}">Notīrīt filtrus</a>
            </div>
        </form>

        @if (filled($filters['genre'] ?? null) || filled($filters['platform'] ?? null) || filled($filters['year'] ?? null) || (($filters['ordering'] ?? '-added') !== '-added'))
            <div class="active-filters" aria-label="Aktīvie filtri">
                <strong>Aktīvs:</strong>
                @if (filled($filters['genre'] ?? null))<span>{{ $genres[$filters['genre']] ?? $filters['genre'] }}</span>@endif
                @if (filled($filters['platform'] ?? null))<span>{{ $platforms[$filters['platform']] ?? $filters['platform'] }}</span>@endif
                @if (filled($filters['year'] ?? null))<span>{{ $filters['year'] }}</span>@endif
                @if (($filters['ordering'] ?? '-added') !== '-added')<span>{{ $orderings[$filters['ordering']] ?? $filters['ordering'] }}</span>@endif
            </div>
        @endif

        @if ($game)
            <article class="result" aria-labelledby="game-title">
                <div class="cover-wrap">
                    @if (filled($game['thumbnail']))
                        <img class="cover" src="{{ $game['thumbnail'] }}" alt="{{ $game['title'] }} spēles attēls">
                    @endif
                    <span class="cover-badge">ATBILST TAVIEM FILTRIEM</span>
                </div>
                <div class="game-info">
                    <p class="result-label">TAVA NEJAUŠĀ SPĒLE</p>
                    <h2 id="game-title">{{ $game['title'] }}</h2>
                    <p class="description">{{ $game['description'] }}</p>
                    <div class="tags">
                        <span>{{ $game['genre'] }}</span>
                        <span>{{ $game['platform'] }}</span>
                        <span>Izlaista: {{ $game['releaseDate'] }}</span>
                        @if ($game['rating'])<span>Vērtējums: {{ number_format($game['rating'], 1) }}/5</span>@endif
                    </div>
                    <div class="actions">
                        <a class="action new-game" href="{{ route('games.random', $filters) }}">Parādīt citu spēli</a>
                        <a class="action game-link" href="{{ route('games.show', ['gameId' => $game['id']]) }}">Apskatīt spēli →</a>
                        <form action="{{ route('favorites.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $game['id'] }}">
                            <input type="hidden" name="title" value="{{ $game['title'] }}">
                            <input type="hidden" name="thumbnail" value="{{ $game['thumbnail'] }}">
                            <input type="hidden" name="url" value="{{ $game['url'] }}">
                            <input type="hidden" name="genre" value="{{ $game['genre'] }}">
                            <input type="hidden" name="platform" value="{{ $game['platform'] }}">
                            <input type="hidden" name="releaseDate" value="{{ $game['releaseDate'] }}">
                            <input type="hidden" name="rating" value="{{ $game['rating'] }}">
                            <input type="hidden" name="description" value="{{ $game['description'] }}">
                            <button class="favorite-button{{ $isFavorite ? ' is-favorite' : '' }}" type="submit">
                                {{ $isFavorite ? 'Noņemt no favorītiem' : 'Pievienot favorītiem' }}
                            </button>
                        </form>
                    </div>

                    @php
                        $gameRating = $ratingsByGameId[(string) $game['id']] ?? null;
                    @endphp
                    <div class="rating-panel">
                        <p class="rating-summary">
                            {{ $gameRating ? 'Lietotāju vērtējums: '.number_format($gameRating['average'], 1).'/10 ('.$gameRating['count'].')' : 'Šo spēli vēl neviens nav novērtējis.' }}
                        </p>
                        @auth
                            <form action="{{ route('games.ratings.store', ['gameId' => $game['id']]) }}" method="POST" class="rating-form">
                                @csrf
                                <input type="hidden" name="game_title" value="{{ $game['title'] }}">
                                <label for="random-rating-{{ $game['id'] }}">Tavs vērtējums</label>
                                <select id="random-rating-{{ $game['id'] }}" name="rating" required>
                                    @for ($rating = 1; $rating <= 10; $rating++)
                                        <option value="{{ $rating }}" @selected(($gameRating['userRating'] ?? null) === $rating)>{{ $rating }}/10</option>
                                    @endfor
                                </select>
                                <button type="submit">Novērtēt</button>
                            </form>
                        @else
                            <p class="rating-login">Pieraksties, lai novērtētu spēli.</p>
                        @endauth
                    </div>
                </div>
            </article>

            <div class="comment-panel">
                <h3>Komentāri</h3>

                @auth
                    @if ($comments->isNotEmpty())
                        <div class="comment-list">
                            @foreach ($comments as $comment)
                                <div class="comment-item">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p>{{ $comment->body }}</p>
                                    @include('components.game-comment-actions', ['comment' => $comment])
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="comment-empty">Vēl nav komentāru. Būt pirmajam!</p>
                    @endif

                    <form action="{{ route('games.comments.store', ['gameId' => $game['id']]) }}" method="POST" class="comment-form">
                        @csrf
                        <input type="hidden" name="game_title" value="{{ $game['title'] }}">
                        <textarea name="body" maxlength="500" placeholder="Atstāj savu komentāru..." required></textarea>
                        <button type="submit">Publicēt komentāru</button>
                    </form>
                @else
                    <p class="comment-login">Pieraksties, lai atstātu komentāru.</p>
                @endauth
            </div>
        @else
            <p class="notice">{{ $error }}</p>
        @endif

        <p class="source">Spēļu dati: <a href="https://rawg.io/" target="_blank" rel="noopener noreferrer">RAWG.io</a></p>
    </main>
</body>
</html>
