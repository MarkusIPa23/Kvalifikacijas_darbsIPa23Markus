<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RandomGameController extends Controller
{
    /**
     * Show a random recommendation or games that match a title search.
     */
    public function __invoke(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'genre' => ['nullable', 'in:mmorpg,shooter,moba,strategy,racing,sports,fighting'],
            'platform' => ['nullable', 'in:pc,browser'],
            'year' => ['nullable', 'in:2010-2015,2016-2020,2021-2026'],
        ]);

        $games = $this->games();

        if ($games === null) {
            return view('random', [
                'game' => null,
                'searchResults' => collect(),
                'isSearching' => filled($filters['search'] ?? null),
                'resultsCount' => 0,
                'filters' => $filters,
                'error' => 'Pašlaik nevarējām saņemt spēļu sarakstu. Lūdzu, pamēģini vēlreiz pēc brīža.',
            ]);
        }

        $matchingGames = $games
            ->filter(fn (array $game): bool => $this->matchesFilters($game, $filters))
            ->values();

        $isSearching = filled($filters['search'] ?? null);

        return view('random', [
            'game' => ! $isSearching && $matchingGames->isNotEmpty() ? $matchingGames->random() : null,
            'searchResults' => $isSearching ? $matchingGames->take(12) : collect(),
            'isSearching' => $isSearching,
            'resultsCount' => $matchingGames->count(),
            'filters' => $filters,
            'error' => $matchingGames->isEmpty()
                ? 'Pēc šiem kritērijiem spēle netika atrasta. Pamēģini izvēlēties mazāk filtru.'
                : null,
        ]);
    }

    /**
     * Get the catalogue once per hour instead of calling the public API on every page load.
     */
    private function games(): ?Collection
    {
        try {
            $games = Cache::remember('freetogame.games', now()->addHour(), function (): array {
                $response = Http::baseUrl(config('services.freetogame.url'))
                    ->acceptJson()
                    ->timeout(10)
                    ->get('games');

                if ($response->failed()) {
                    throw new ConnectionException('FreeToGame API request failed.');
                }

                return $response->json();
            });

            return collect($games)
                ->filter(fn (mixed $game): bool => is_array($game) && filled($game['title'] ?? null))
                ->values();
        } catch (ConnectionException) {
            return null;
        }
    }

    /**
     * Apply filters locally because the API's filter options are limited.
     *
     * @param  array<string, mixed>  $game
     * @param  array<string, string>  $filters
     */
    private function matchesFilters(array $game, array $filters): bool
    {
        $search = trim($filters['search'] ?? '');

        if ($search !== '' && ! Str::contains(Str::lower($game['title'] ?? ''), Str::lower($search))) {
            return false;
        }

        if (($filters['genre'] ?? null) && strcasecmp($game['genre'] ?? '', $filters['genre']) !== 0) {
            return false;
        }

        $platform = strtolower($game['platform'] ?? '');

        if (($filters['platform'] ?? null) === 'pc' && ! str_contains($platform, 'pc')) {
            return false;
        }

        if (($filters['platform'] ?? null) === 'browser' && ! str_contains($platform, 'browser')) {
            return false;
        }

        if (! ($filters['year'] ?? null)) {
            return true;
        }

        [$from, $to] = array_map('intval', explode('-', $filters['year']));
        $releaseYear = (int) substr((string) ($game['release_date'] ?? ''), 0, 4);

        return $releaseYear >= $from && $releaseYear <= $to;
    }
}
