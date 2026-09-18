<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nejauša spēle — Game to Top</title>
    <style>
        :root { --ink: #15203a; --muted: #65718a; --purple: #6d4aff; --purple-dark: #4f2bdf; --bg: #f5f7fc; --line: #dfe5ee; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: radial-gradient(circle at 88% 5%, #e5dfff 0, transparent 26rem), var(--bg); font-family: Arial, sans-serif; }
        .container { width: min(100% - 40px, 960px); margin: 0 auto; padding: 28px 0 72px; }
        header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 80px; }
        .brand, .search-link, .new-game { color: inherit; font-weight: bold; text-decoration: none; }
        .brand { font-size: 1.08rem; }
        .search-link { padding: 10px 14px; border: 1px solid #d8d0ff; border-radius: 9px; color: var(--purple); background: #f7f5ff; font-size: .88rem; }
        .search-link:hover { border-color: var(--purple); }
        .eyebrow { margin: 0 0 12px; color: var(--purple); font-size: .75rem; font-weight: bold; letter-spacing: .12em; }
        h1 { max-width: 670px; margin: 0 0 15px; font-size: clamp(2.65rem, 7vw, 4.7rem); letter-spacing: -.065em; line-height: 1; }
        .intro { max-width: 590px; margin: 0 0 34px; color: var(--muted); font-size: 1.08rem; line-height: 1.65; }
        .result { display: grid; grid-template-columns: 315px 1fr; overflow: hidden; border: 1px solid var(--line); border-radius: 20px; background: #fff; box-shadow: 0 18px 45px rgba(35, 49, 78, .1); }
        .cover { width: 100%; height: 100%; min-height: 310px; object-fit: cover; background: #e7eaf2; }
        .game-info { padding: 34px; }
        .result-label { margin: 0 0 13px; color: var(--purple); font-size: .72rem; font-weight: bold; letter-spacing: .12em; }
        h2 { margin: 0 0 13px; font-size: clamp(1.9rem, 4vw, 2.65rem); letter-spacing: -.045em; }
        .description { max-width: 520px; color: var(--muted); line-height: 1.6; }
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 20px 0 24px; }
        .tags span { padding: 7px 10px; border-radius: 7px; color: #43516a; background: #eef1f7; font-size: .78rem; font-weight: bold; }
        .actions { display: flex; flex-wrap: wrap; gap: 11px; }
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
        .comment-panel { margin-top: 22px; padding: 20px; border: 1px solid var(--line); border-radius: 16px; background: #fff; box-shadow: 0 14px 30px rgba(35, 49, 78, .06); }
        .comment-panel h3 { margin: 0 0 16px; font-size: 1.1rem; }
        .comment-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
        .comment-item { padding: 12px 14px; border: 1px solid #eef1f7; border-radius: 10px; background: #f9fafc; }
        .comment-item strong { display: block; margin-bottom: 4px; color: var(--purple); font-size: .76rem; }
        .comment-item p { margin: 0; color: var(--ink); line-height: 1.5; }
        .comment-form { display: flex; flex-direction: column; gap: 8px; }
        .comment-form textarea { width: 100%; min-height: 80px; padding: 10px 12px; border: 1px solid #dfe5ee; border-radius: 10px; background: #fff; color: var(--ink); resize: vertical; font: inherit; }
        .comment-form button { align-self: flex-start; padding: 10px 16px; border: 0; border-radius: 10px; color: #fff; background: var(--purple); font-weight: bold; cursor: pointer; }
        .comment-empty, .comment-login { color: var(--muted); font-size: .82rem; }
        .notice { padding: 22px; border: 1px solid #f0d997; border-radius: 14px; color: #705622; background: #fff9e9; line-height: 1.55; }
        .source { margin: 25px 0 0; color: #778298; font-size: .8rem; text-align: right; }
        .source a { color: inherit; }
        @media (max-width: 700px) { .container { width: min(100% - 32px, 960px); } header { margin-bottom: 52px; } .result { grid-template-columns: 1fr; } .cover { max-height: 245px; min-height: 0; } .game-info { padding: 25px; } }
    </style>
</head>
<body>
    <main class="container">
        <header>
            <a class="brand" href="{{ route('home') }}">Game to Top</a>
            <a class="search-link" href="{{ route('games.search') }}">Meklēt spēles</a>
        </header>

        <p class="eyebrow">NEJAUŠS IETEIKUMS</p>
        <h1>Atrodi ko negaidītu.</h1>
        <p class="intro">Šeit nav meklēšanas vai filtru — tikai viena nejauši izvēlēta spēle. Spied pogu, lai uzreiz redzētu citu.</p>

        @if ($game)
            <article class="result" aria-labelledby="game-title">
                @if (filled($game['thumbnail']))
                    <img class="cover" src="{{ $game['thumbnail'] }}" alt="{{ $game['title'] }} spēles attēls">
                @endif
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
                        <a class="action new-game" href="{{ route('games.random') }}">Parādīt citu spēli</a>
                        <a class="action game-link" href="{{ $game['url'] }}" target="_blank" rel="noopener noreferrer">Apskatīt RAWG →</a>
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
