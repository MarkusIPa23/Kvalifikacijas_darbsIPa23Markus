<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RawgGameService
{
    public function exists(int $gameId): bool
    {
        if (blank(config('services.rawg.key'))) {
            return false;
        }

        return Cache::remember(
            "rawg.game.exists.{$gameId}",
            now()->addMinutes(15),
            function () use ($gameId): bool {
                try {
                    Http::baseUrl(config('services.rawg.url'))
                        ->acceptJson()
                        ->connectTimeout(3)
                        ->timeout(10)
                        ->get("games/{$gameId}", ['key' => config('services.rawg.key')])
                        ->throw();

                    return true;
                } catch (ConnectionException|RequestException) {
                    return false;
                }
            },
        );
    }
}
