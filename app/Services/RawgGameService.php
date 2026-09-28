<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class RawgGameService
{
    /**
     * @return array<string, mixed>|null
     */
    public function find(int $gameId): ?array
    {
        if (blank(config('services.rawg.key'))) {
            throw new ServiceUnavailableHttpException(null, 'Spēļu katalogs pašlaik nav pieejams.');
        }

        return Cache::remember(
            "rawg.game.{$gameId}",
            now()->addMinutes(15),
            function () use ($gameId): ?array {
                try {
                    $response = Http::baseUrl(config('services.rawg.url'))
                        ->acceptJson()
                        ->connectTimeout(3)
                        ->timeout(10)
                        ->get("games/{$gameId}", ['key' => config('services.rawg.key')]);

                    if ($response->notFound()) {
                        return null;
                    }

                    $game = $response->throw()->json();

                    if (! is_array($game)) {
                        throw new ServiceUnavailableHttpException(null, 'Spēļu katalogs atgrieza nederīgu atbildi.');
                    }

                    return $game;
                } catch (ConnectionException|RequestException $exception) {
                    throw new ServiceUnavailableHttpException(
                        null,
                        'Spēļu katalogs pašlaik nav pieejams. Lūdzu, mēģini vēlreiz vēlāk.',
                        $exception,
                    );
                }
            },
        );
    }

    public function exists(int $gameId): bool
    {
        return $this->find($gameId) !== null;
    }
}
