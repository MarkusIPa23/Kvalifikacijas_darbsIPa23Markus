<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meklēt spēles — Game to Top</title>
    <style>
        :root { --ink: #15203a; --muted: #65718a; --purple: #6d4aff; --purple-dark: #4f2bdf; --bg: #f5f7fc; --line: #dfe5ee; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: radial-gradient(circle at 88% 5%, #e5dfff 0, transparent 28rem), var(--bg); font-family: Arial, sans-serif; }
        .container { width: min(100% - 40px, 1120px); margin: 0 auto; padding: 28px 0 72px; }
        header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 60px; }
        .brand, .random-link { font-weight: bold; text-decoration: none; }
        .brand { color: var(--ink); font-size: 1.08rem; }
        .random-link { padding: 10px 14px; border: 1px solid #d8d0ff; border-radius: 9px; color: var(--purple); background: #f7f5ff; font-size: .88rem; }
        .random-link:hover { border-color: var(--purple); }
        .eyebrow { margin: 0 0 12px; color: var(--purple); font-size: .75rem; font-weight: bold; letter-spacing: .12em; }
        h1 { margin: 0 0 14px; font-size: clamp(2.65rem, 6vw, 4.4rem); letter-spacing: -.065em; line-height: 1; }
        .intro { max-width: 650px; margin: 0 0 35px; color: var(--muted); font-size: 1.05rem; line-height: 1.65; }
        .filters { padding: 25px; border: 1px solid var(--line); border-radius: 20px; background: #fff; box-shadow: 0 18px 45px rgba(35, 49, 78, .1); }
        .filter-grid { display: grid; grid-template-columns: 2fr repeat(4, 1fr); gap: 14px; }
        label { display: block; margin-bottom: 8px; color: #3b4860; font-size: .78rem; font-weight: bold; }
        input, select { width: 100%; height: 46px; padding: 0 12px; border: 1px solid #d9e0eb; border-radius: 10px; color: var(--ink); background: #fbfcfe; font-size: .92rem; }
        input:focus, select:focus { outline: 3px solid #ded7ff; border-color: var(--purple); }
        .form-actions { display: flex; align-items: center; gap: 14px; margin-top: 20px; }
        button { min-height: 47px; padding: 0 20px; border: 0; border-radius: 10px; color: #fff; background: var(--purple); box-shadow: 0 10px 20px rgba(109, 74, 255, .25); font-size: .92rem; font-weight: bold; cursor: pointer; }
        button:hover { background: var(--purple-dark); }
        .reset { color: #61708a; font-size: .88rem; font-weight: bold; text-decoration: none; }
        .reset:hover { color: var(--purple); }
        .results-heading { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin: 40px 0 20px; }
        h2 { margin: 0; font-size: 1.6rem; letter-spacing: -.04em; }
        .count { margin: 0; color: var(--muted); font-size: .9rem; }
        .game-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .game-card { overflow: hidden; border: 1px solid var(--line); border-radius: 16px; background: #fff; box-shadow: 0 12px 30px rgba(35, 49, 78, .08); }
        .cover { display: block; width: 100%; height: 142px; object-fit: cover; background: #e7eaf2; }
        .card-info { padding: 17px; }
        h3 { margin: 0 0 9px; font-size: 1.08rem; line-height: 1.2; }
        .metadata { min-height: 39px; margin: 0 0 16px; color: var(--muted); font-size: .78rem; line-height: 1.45; }
        .game-link { display: inline-block; color: var(--purple); font-size: .85rem; font-weight: bold; text-decoration: none; }
        .game-link:hover { color: var(--purple-dark); }
        .favorite-form { margin-top: 12px; }
        .favorite-button { width: 100%; min-height: 38px; padding: 0 12px; border: 1px solid #e1d9ff; border-radius: 9px; color: var(--purple); background: #f7f5ff; font-size: .8rem; font-weight: bold; cursor: pointer; }
        .favorite-button.is-favorite { border-color: #f2c96d; color: #8a6410; background: #fff8df; }
        .favorite-button:hover { border-color: var(--purple); }
        .rating-panel { margin-top: 14px; padding: 12px; border: 1px solid #ebe7ff; border-radius: 10px; background: #fbfaff; }
        .rating-summary { margin: 0 0 9px; color: var(--ink); font-size: .8rem; font-weight: bold; }
        .rating-form { display: flex; align-items: center; gap: 8px; }
        .rating-form label { margin: 0; color: var(--muted); font-size: .76rem; }
        .rating-form select { width: auto; min-width: 66px; height: 34px; padding: 0 8px; font-size: .8rem; }
        .rating-form button { min-height: 34px; padding: 0 10px; border-radius: 8px; font-size: .76rem; }
        .rating-login { margin: 0; color: var(--muted); font-size: .76rem; }
        .game-comments { margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--line); }
        .comment-item { margin-bottom: 10px; padding: 9px 10px; border: 1px solid #eef1f7; border-radius: 10px; background: #f9fafc; }
        .comment-item strong { display: block; margin-bottom: 4px; font-size: .75rem; color: var(--purple); }
        .comment-item p { margin: 0; color: var(--ink); font-size: .82rem; line-height: 1.5; }
        .comment-empty, .comment-login { margin: 0 0 10px; color: var(--muted); font-size: .76rem; }
        .comment-form { margin-top: 12px; }
        .comment-form textarea { width: 100%; min-height: 70px; padding: 10px 12px; border: 1px solid #dfe5ee; border-radius: 10px; background: #fff; color: var(--ink); resize: vertical; font: inherit; }
        .comment-form button { width: 100%; margin-top: 8px; min-height: 36px; padding: 0 12px; border: 0; border-radius: 9px; color: #fff; background: var(--purple); font-size: .8rem; font-weight: bold; cursor: pointer; }
        .notice { margin-top: 35px; padding: 22px; border: 1px solid #f0d997; border-radius: 14px; color: #705622; background: #fff9e9; line-height: 1.55; }
        .empty { margin-top: 35px; padding: 30px; border: 1px dashed #c8d1df; border-radius: 15px; color: var(--muted); background: #fff; text-align: center; }
        .pagination { display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 35px; }
        .pagination a, .pagination span { padding: 10px 13px; border-radius: 9px; font-size: .87rem; font-weight: bold; }
        .pagination a { border: 1px solid #d8d0ff; color: var(--purple); background: #fff; text-decoration: none; }
        .pagination a:hover { color: #fff; background: var(--purple); }
        .pagination .disabled { color: #9da8b9; background: #edf0f5; }
        .source { margin: 27px 0 0; color: #778298; font-size: .8rem; text-align: right; }
        .source a { color: inherit; }
        @media (max-width: 950px) { .filter-grid { grid-template-columns: repeat(3, 1fr); } .filter-grid > :first-child { grid-column: span 3; } .game-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 700px) { .container { width: min(100% - 32px, 1120px); } header { margin-bottom: 48px; } .filter-grid, .game-grid { grid-template-columns: 1fr; } .filter-grid > :first-child { grid-column: auto; } .results-heading { align-items: start; flex-direction: column; } .game-grid { gap: 14px; } .cover { height: 175px; } }
    </style>
</head>
<body>
    <main class="container">
        <header>
            <a class="brand" href="{{ route('home') }}">Game to Top</a>
            <a class="random-link" href="{{ route('games.random') }}">Nejauša spēle</a>
        </header>

        <p class="eyebrow">SPĒĻU MEKLĒTĀJS</p>
        <h1>Atrodi īsto spēli.</h1>
        <p class="intro">Meklē pēc spēles nosaukuma vai izmanto filtrus. Rezultāti tiek iegūti tieši no RAWG kataloga, un vari pāriet uz nākamajām lapām, lai apskatītu visas atbilstošās spēles.</p>

        <form class="filters" action="{{ route('games.search') }}" method="GET">
            <div class="filter-grid">
                <div>
                    <label for="search">Spēles nosaukums</label>
                    <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Piemēram, Minecraft">
                </div>
                <div>
                    <label for="genre">Žanrs</label>
                    <select id="genre" name="genre">
                        <option value="">Visi žanri</option>
                        @foreach ($genres as $slug => $name)
                            <option value="{{ $slug }}" @selected(($filters['genre'] ?? '') === $slug)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="platform">Platforma</label>
                    <select id="platform" name="platform">
                        <option value="">Visas platformas</option>
                        @foreach ($platforms as $slug => $name)
                            <option value="{{ $slug }}" @selected(($filters['platform'] ?? '') === $slug)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year">Izdošanas gads</label>
                    <input id="year" name="year" type="number" min="1950" max="{{ now()->year + 1 }}" value="{{ $filters['year'] ?? '' }}" placeholder="Piem., 2024">
                </div>
                <div>
                    <label for="ordering">Kārtot pēc</label>
                    <select id="ordering" name="ordering">
                        @foreach ($orderings as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['ordering'] ?? '-added') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit">Meklēt spēles</button>
                <a class="reset" href="{{ route('games.search') }}">Notīrīt filtrus</a>
            </div>
        </form>

        @if ($error)
            <p class="notice">{{ $error }}</p>
        @elseif ($games->isEmpty())
            <p class="empty">Pēc šiem kritērijiem spēles netika atrastas. Pamēģini citu nosaukumu vai noņem kādu filtru.</p>
        @else
            <div class="results-heading">
                <h2>Meklēšanas rezultāti</h2>
                <p class="count">Atrastas {{ number_format($games->total()) }} spēles · lapa {{ $games->currentPage() }} no {{ $games->lastPage() }}</p>
            </div>
            <section class="game-grid" aria-label="Spēļu rezultāti">
                @foreach ($games as $game)
                    <article class="game-card">
                        @if (filled($game['thumbnail']))
                            <img class="cover" src="{{ $game['thumbnail'] }}" alt="{{ $game['title'] }} spēles attēls">
                        @endif
                        <div class="card-info">
                            <h3>{{ $game['title'] }}</h3>
                            <p class="metadata">
                                {{ $game['genre'] }}<br>
                                {{ $game['releaseDate'] }}
                                @if ($game['rating'])
                                    · {{ number_format($game['rating'], 1) }}/5
                                @endif
                            </p>
                            <a class="game-link" href="{{ $game['url'] }}" target="_blank" rel="noopener noreferrer">Apskatīt RAWG →</a>
                            <form class="favorite-form" action="{{ route('favorites.toggle') }}" method="POST">
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
                                <button class="favorite-button{{ isset($favoriteIds[(string) $game['id']]) ? ' is-favorite' : '' }}" type="submit">
                                    {{ isset($favoriteIds[(string) $game['id']]) ? 'Noņemt no favorītiem' : 'Pievienot favorītiem' }}
                                </button>
                            </form>

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
                                        <label for="rating-{{ $game['id'] }}">Tavs vērtējums</label>
                                        <select id="rating-{{ $game['id'] }}" name="rating" required>
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

                            @php
                                $gameComments = collect($commentsByGameId[(string) $game['id']] ?? []);
                            @endphp

                            <div class="game-comments">
                                @auth
                                    @forelse ($gameComments as $comment)
                                        <div class="comment-item">
                                            <strong>{{ $comment->user->name }}</strong>
                                            <p>{{ $comment->body }}</p>
                                        </div>
                                    @empty
                                        <p class="comment-empty">Vēl nav komentāru.</p>
                                    @endforelse

                                    <form action="{{ route('games.comments.store', ['gameId' => $game['id']]) }}" method="POST" class="comment-form">
                                        @csrf
                                        <input type="hidden" name="game_title" value="{{ $game['title'] }}">
                                        <textarea name="body" rows="2" maxlength="500" placeholder="Atstāj komentāru..." required></textarea>
                                        <button type="submit">Publicēt</button>
                                    </form>
                                @else
                                    <p class="comment-login">Pieraksties, lai atstātu komentāru.</p>
                                @endauth
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            @if ($games->hasPages())
                <nav class="pagination" aria-label="Spēļu rezultātu lapas">
                    @if ($games->onFirstPage())<span class="disabled">← Iepriekšējā</span>@else<a href="{{ $games->previousPageUrl() }}">← Iepriekšējā</a>@endif
                    <span>{{ $games->currentPage() }} / {{ $games->lastPage() }}</span>
                    @if ($games->hasMorePages())<a href="{{ $games->nextPageUrl() }}">Nākamā →</a>@else<span class="disabled">Nākamā →</span>@endif
                </nav>
            @endif
        @endif

        <p class="source">Spēļu dati: <a href="https://rawg.io/" target="_blank" rel="noopener noreferrer">RAWG.io</a></p>
    </main>
</body>
</html>
