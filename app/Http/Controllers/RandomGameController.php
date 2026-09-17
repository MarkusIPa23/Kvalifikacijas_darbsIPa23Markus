<?php

namespace App\Http\Controllers;

use App\Models\GameComment;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RandomGameController extends Controller
{
    private const PAGE_SIZE = 12;

    /** @var array<string, string> */
    private const GENRES = [
        'action' => 'Action',
        'adventure' => 'Adventure',
        'arcade' => 'Arcade',
        'fighting' => 'Fighting',
        'indie' => 'Indie',
        'platformer' => 'Platformer',
        'puzzle' => 'Puzzle',
        'racing' => 'Racing',
        'role-playing-games-rpg' => 'RPG',
        'shooter' => 'Shooter',
        'simulation' => 'Simulation',
        'sports' => 'Sports',
        'strategy' => 'Strategy',
    ];

    /** @var array<string, string> */
    private const PLATFORMS = [
        'pc' => 'PC',
        'playstation' => 'PlayStation',
        'xbox' => 'Xbox',
        'nintendo-switch' => 'Nintendo Switch',
    ];

    /** @var array<string, string> */
    private const PLATFORM_IDS = [
        'pc' => '4',
        'playstation' => '187,18,16,15,27,19,17',
        'xbox' => '186,1,14,80',
        'nintendo-switch' => '7',
    ];

    /** @var array<string, string> */
    private const ORDERINGS = [
        '-added' => 'Populārākās',
        '-rating' => 'Augstākais vērtējums',
        '-released' => 'Jaunākās',
        'name' => 'Nosaukums A–Z',
    ];

    /**
     * Show the searchable RAWG catalogue with filters and pagination.
     */
    public function search(Request $request): View
    {
        $filters = $this->validatedFilters($request);
        $page = $request->integer('page', 1);
        $catalogue = $this->catalogue($filters, $page);
        $commentsByGameId = GameComment::with('user')->latest()->get()->groupBy(fn (GameComment $comment): string => (string) $comment->game_id)->map(fn ($comments) => $comments->take(2)->values());

        if ($catalogue === null) {
            return view('games', [
                'games' => $this->paginator(collect(), 0, $page, $request),
                'filters' => $filters,
                'genres' => self::GENRES,
                'platforms' => self::PLATFORMS,
                'orderings' => self::ORDERINGS,
                'favoriteIds' => $this->favoriteIds($request),
                'commentsByGameId' => $commentsByGameId->all(),
                'error' => 'Pašlaik nevarējām saņemt spēļu sarakstu. Lūdzu, pamēģini vēlreiz pēc brīža.',
            ]);
        }

        $favoriteIds = $this->favoriteIds($request);

        return view('games', [
            'games' => $this->paginator($catalogue['games'], $catalogue['total'], $page, $request),
            'filters' => $filters,
            'genres' => self::GENRES,
            'platforms' => self::PLATFORMS,
            'orderings' => self::ORDERINGS,
            'favoriteIds' => $favoriteIds,
            'commentsByGameId' => $commentsByGameId->all(),
            'error' => null,
        ]);
    }

    public function toggleFavorite(Request $request): RedirectResponse
    {
        $game = $request->validate([
            'id' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'url', 'max:2048'],
            'url' => ['required', 'url', 'max:2048'],
            'genre' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', 'max:255'],
            'releaseDate' => ['required', 'string', 'max:30'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $favorites = $this->favorites($request);
        $id = (string) $game['id'];

        if (array_key_exists($id, $favorites)) {
            unset($favorites[$id]);
        } else {
            $favorites[$id] = $game;
        }

        $request->session()->put('favorite_games', $favorites);

        if ($request->user() !== null) {
            $request->user()->update(['favorite_games' => $favorites]);
        }

        return back();
    }

    /**
     * Show one different random game each time the user presses the button.
     */
    public function random(Request $request): View
    {
        $total = $this->totalGames();

        if ($total === null || $total === 0) {
            return view('random', [
                'game' => null,
                'error' => 'Pašlaik nevarējām saņemt nejaušu spēli. Lūdzu, pamēģini vēlreiz pēc brīža.',
            ]);
        }

        $lastGameId = $request->session()->get('last_random_game_id');
        $maxPage = max(1, (int) ceil($total / self::PAGE_SIZE));
        $game = null;

        for ($attempt = 0; $attempt < 5 && $game === null; $attempt++) {
            $catalogue = $this->catalogue([], random_int(1, $maxPage));

            if ($catalogue === null || $catalogue['games']->isEmpty()) {
                continue;
            }

            $candidates = $catalogue['games']->reject(
                fn (array $candidate): bool => $candidate['id'] === $lastGameId,
            );

            if ($candidates->isNotEmpty()) {
                $game = $candidates->random();
            }
        }

        if ($game === null) {
            return view('random', [
                'game' => null,
                'error' => 'Pašlaik nevarējām saņemt nejaušu spēli. Lūdzu, pamēģini vēlreiz pēc brīža.',
            ]);
        }

        $request->session()->put('last_random_game_id', $game['id']);

        return view('random', [
            'game' => $game,
            'isFavorite' => $this->isFavorite($request, $game['id']),
            'comments' => GameComment::with('user')->where('game_id', (string) $game['id'])->latest()->limit(5)->get(),
            'error' => null,
        ]);
    }

    /**
     * Validate only filters accepted by the API and keep the search query in the URL.
     *
     * @return array<string, string>
     */
    private function validatedFilters(Request $request): array
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'genre' => ['nullable', Rule::in(array_keys(self::GENRES))],
            'platform' => ['nullable', Rule::in(array_keys(self::PLATFORMS))],
            'year' => ['nullable', 'integer', 'min:1950', 'max:'.(now()->year + 1)],
            'ordering' => ['nullable', Rule::in(array_keys(self::ORDERINGS))],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        unset($filters['page']);

        return $filters;
    }

    /**
     * Fetch a single catalogue page. Its cache key includes every selected filter.
     *
     * @param  array<string, string>  $filters
     * @return array{games: Collection<int, array<string, mixed>>, total: int}|null
     */
    private function catalogue(array $filters, int $page): ?array
    {
        if (blank(config('services.rawg.key'))) {
            return null;
        }

        $query = $this->apiQuery($filters, $page);
        $cacheKey = 'rawg.catalogue.'.md5(http_build_query(Arr::except($query, 'key')));

        try {
            $payload = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($query): array {
                $response = Http::baseUrl(config('services.rawg.url'))
                    ->acceptJson()
                    ->timeout(10)
                    ->get('games', $query)
                    ->throw();

                return $response->json();
            });

            return [
                'games' => collect($payload['results'] ?? [])
                    ->filter(fn (mixed $game): bool => is_array($game) && filled($game['name'] ?? null))
                    ->map(fn (array $game): array => $this->normalizeGame($game))
                    ->values(),
                'total' => (int) ($payload['count'] ?? 0),
            ];
        } catch (ConnectionException|RequestException) {
            return null;
        }
    }

    /**
     * Cache the catalogue count for a day; selecting a random page then needs only one request.
     */
    private function totalGames(): ?int
    {
        if (blank(config('services.rawg.key'))) {
            return null;
        }

        try {
            return Cache::remember('rawg.catalogue.total', now()->addDay(), function (): int {
                $response = Http::baseUrl(config('services.rawg.url'))
                    ->acceptJson()
                    ->timeout(10)
                    ->get('games', [
                        'key' => config('services.rawg.key'),
                        'page' => 1,
                        'page_size' => 1,
                    ])
                    ->throw();

                return (int) $response->json('count', 0);
            });
        } catch (ConnectionException|RequestException) {
            return null;
        }
    }

    /** @return array<string, bool> */
    private function favoriteIds(Request $request): array
    {
        return collect($this->favorites($request))
            ->mapWithKeys(fn (array $game): array => [(string) $game['id'] => true])
            ->all();
    }

    private function isFavorite(Request $request, int $gameId): bool
    {
        return array_key_exists((string) $gameId, $this->favorites($request));
    }

    /** @return array<string, array<string, mixed>> */
    private function favorites(Request $request): array
    {
        return $request->user()?->favorite_games
            ?? $request->session()->get('favorite_games', []);
    }

    /**
     * @param  array<string, string>  $filters
     * @return array<string, int|string>
     */
    private function apiQuery(array $filters, int $page): array
    {
        $query = [
            'key' => config('services.rawg.key'),
            'page' => $page,
            'page_size' => self::PAGE_SIZE,
            'ordering' => $filters['ordering'] ?? '-added',
        ];

        if (filled($filters['search'] ?? null)) {
            $query['search'] = trim($filters['search']);
        }

        if (filled($filters['genre'] ?? null)) {
            $query['genres'] = $filters['genre'];
        }

        if (filled($filters['platform'] ?? null)) {
            $query['platforms'] = self::PLATFORM_IDS[$filters['platform']];
        }

        if (filled($filters['year'] ?? null)) {
            $query['dates'] = $filters['year'].'-01-01,'.$filters['year'].'-12-31';
        }

        return $query;
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $games
     */
    private function paginator(Collection $games, int $total, int $page, Request $request): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $games,
            $total,
            self::PAGE_SIZE,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->except('page'),
            ],
        );
    }

    /**
     * Convert RAWG's nested response into fields used by the views.
     *
     * @param  array<string, mixed>  $game
     * @return array<string, mixed>
     */
    private function normalizeGame(array $game): array
    {
        $genres = collect($game['genres'] ?? [])
            ->pluck('name')
            ->filter()
            ->values();
        $platforms = collect($game['platforms'] ?? [])
            ->map(fn (mixed $platform): mixed => is_array($platform) ? ($platform['platform']['name'] ?? null) : null)
            ->filter()
            ->values();

        return [
            'id' => (int) ($game['id'] ?? 0),
            'title' => $game['name'],
            'thumbnail' => $game['background_image'] ?? null,
            'description' => $game['description_raw'] ?? 'Apraksts nav pieejams.',
            'url' => 'https://rawg.io/games/'.($game['slug'] ?? ''),
            'genre' => $genres->implode(', ') ?: 'Nezināms žanrs',
            'platform' => $platforms->implode(', ') ?: 'Nezināma platforma',
            'releaseDate' => $game['released'] ?? 'Nav norādīts',
            'rating' => $game['rating'] ?? null,
        ];
    }
}
