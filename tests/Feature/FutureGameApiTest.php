<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FutureGameApiTest extends TestCase
{
    public function test_future_games_returns_normalized_rawg_games(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://api.rawg.io/api/games*' => Http::response([
                'count' => 1,
                'results' => [[
                    'id' => 4200,
                    'name' => 'The Legend of Zelda',
                    'slug' => 'the-legend-of-zelda',
                    'background_image' => 'https://example.com/zelda.jpg',
                    'rating' => 4.5,
                    'genres' => [['name' => 'Action']],
                    'platforms' => [['platform' => ['name' => 'PC']]],
                ]],
            ]),
        ]);

        $this->getJson('/future/games?page_size=8&genres[]=action')
            ->assertOk()
            ->assertJsonPath('data.0.id', 4200)
            ->assertJsonPath('data.0.title', 'The Legend of Zelda')
            ->assertJsonPath('data.0.genres.0', 'Action')
            ->assertJsonPath('data.0.platforms.0', 'PC')
            ->assertJsonPath('meta.page_size', 8);

        Http::assertSent(fn (Request $request): bool => str_contains($request->url(), 'genres=action')
            && str_contains($request->url(), 'page_size=8'));
    }

    public function test_future_games_rejects_unsupported_genres(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::preventStrayRequests();

        $this->getJson('/future/games?genres[]=not-a-genre')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('genres.0');

        Http::assertNothingSent();
    }

    public function test_future_games_returns_service_unavailable_when_rawg_fails(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://api.rawg.io/api/games*' => Http::failedConnection(),
        ]);

        $this->getJson('/future/games')
            ->assertStatus(503)
            ->assertJsonPath('message', 'Spēļu katalogs pašlaik nav pieejams. Lūdzu, mēģini vēlreiz vēlāk.');
    }

    public function test_future_games_requires_a_configured_rawg_key(): void
    {
        config(['services.rawg.key' => null]);

        $this->getJson('/future/games')->assertStatus(503);
    }

    public function test_future_pages_render_the_shared_games_api_helper(): void
    {
        foreach (['hybrid', 'random', 'comparison', 'matches', 'tournament'] as $page) {
            $this->get('/future/'.$page)
                ->assertOk()
                ->assertSee('FutureGamesApi', false)
                ->assertSee('store-wallpaper', false);
        }
    }
}
