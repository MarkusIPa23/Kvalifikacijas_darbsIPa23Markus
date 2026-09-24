<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $game['title'] }} — Game to Top</title>
    <style>
        :root { --ink: #15203a; --muted: #65718a; --purple: #6d4aff; --bg: #f5f7fc; --line: #dfe5ee; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: radial-gradient(circle at 88% 5%, #e5dfff 0, transparent 28rem), var(--bg); font-family: Arial, sans-serif; }
        .container { width: min(100% - 40px, 960px); margin: 0 auto; padding: 28px 0 72px; }
        header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 55px; }
        a { color: var(--purple); font-weight: bold; text-decoration: none; }
        .brand { color: var(--ink); }
        .back { padding: 10px 14px; border: 1px solid #d8d0ff; border-radius: 9px; background: #f7f5ff; font-size: .88rem; }
        .detail { overflow: hidden; border: 1px solid var(--line); border-radius: 20px; background: #fff; box-shadow: 0 18px 45px rgba(35, 49, 78, .1); }
        .cover { display: block; width: 100%; max-height: 430px; object-fit: cover; background: #e7eaf2; }
        .content { padding: 34px; }
        .eyebrow { margin: 0 0 12px; color: var(--purple); font-size: .75rem; font-weight: bold; letter-spacing: .12em; }
        h1 { margin: 0 0 16px; font-size: clamp(2.2rem, 6vw, 4.4rem); letter-spacing: -.06em; line-height: 1; }
        .description { color: var(--muted); line-height: 1.7; }
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 24px 0; }
        .tags span { padding: 8px 10px; border-radius: 7px; color: #43516a; background: #eef1f7; font-size: .8rem; font-weight: bold; }
        .actions { display: flex; flex-wrap: wrap; gap: 11px; align-items: center; }
        button, .action { min-height: 42px; padding: 11px 16px; border: 0; border-radius: 9px; font: inherit; font-weight: bold; cursor: pointer; }
        button { color: #8a6410; background: #fff8df; }
        .action { color: #fff; background: var(--purple); }
        .rawg { color: var(--purple); background: #f0edff; }
        .panel { margin-top: 22px; padding: 22px; border: 1px solid var(--line); border-radius: 16px; background: #fff; }
        .panel h2 { margin: 0 0 16px; font-size: 1.15rem; }
        .comment { padding: 12px 0; border-top: 1px solid var(--line); }
        .comment strong { color: var(--purple); font-size: .82rem; }
        .comment p { margin: 5px 0 0; line-height: 1.5; }
        .muted { color: var(--muted); font-size: .88rem; }
        @media (max-width: 600px) { .container { width: min(100% - 32px, 960px); } .content { padding: 25px; } }
    </style>
</head>
<body>
    <main class="container">
        <header>
            <a class="brand" href="{{ route('home') }}">Game to Top</a>
            <a class="back" href="{{ route('games.search') }}">Atpakaļ uz spēlēm</a>
        </header>

        <article class="detail">
            @if (filled($game['thumbnail']))
                <img class="cover" src="{{ $game['thumbnail'] }}" alt="{{ $game['title'] }} spēles attēls">
            @endif
            <div class="content">
                <p class="eyebrow">SPĒLES INFORMĀCIJA</p>
                <h1>{{ $game['title'] }}</h1>
                <p class="description">{{ $game['description'] }}</p>
                <div class="tags">
                    <span>{{ $game['genre'] }}</span>
                    <span>{{ $game['platform'] }}</span>
                    <span>Izlaista: {{ $game['releaseDate'] }}</span>
                    @if ($game['rating'])<span>RAWG vērtējums: {{ number_format($game['rating'], 1) }}/5</span>@endif
                </div>
                <div class="actions">
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
                        <button type="submit">{{ $isFavorite ? 'Noņemt no favorītiem' : 'Pievienot favorītiem' }}</button>
                    </form>
                    <a class="action rawg" href="{{ $game['url'] }}" target="_blank" rel="noopener noreferrer">Apskatīt RAWG</a>
                </div>
            </div>
        </article>

        <section class="panel">
            <h2>Lietotāju vērtējums</h2>
            @php($rating = $ratingsByGameId[(string) $game['id']] ?? null)
            @if ($rating)
                <p class="muted">{{ number_format($rating['average'], 1) }}/10 no {{ $rating['count'] }} vērtējumiem.</p>
            @else
                <p class="muted">Šo spēli vēl neviens nav novērtējis.</p>
            @endif
        </section>

        <section class="panel">
            <h2>Komentāri</h2>
            @forelse ($comments as $comment)
                <div class="comment"><strong>{{ $comment->user->name }}</strong><p>{{ $comment->body }}</p></div>
            @empty
                <p class="muted">Šai spēlei vēl nav komentāru.</p>
            @endforelse
        </section>
    </main>
</body>
</html>
