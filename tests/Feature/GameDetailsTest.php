<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_detail_page_displays_rawg_game_information(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::fake([
            'https://api.rawg.io/api/games/4200*' => Http::response([
                'id' => 4200,
                'name' => 'The Legend of Zelda',
                'slug' => 'the-legend-of-zelda',
                'description_raw' => 'A legendary adventure.',
                'released' => '1986-02-21',
                'rating' => 4.5,
                'genres' => [['name' => 'Adventure']],
                'platforms' => [['platform' => ['name' => 'Nintendo Switch']]],
            ]),
        ]);

        $this->get('/games/4200')
            ->assertOk()
            ->assertSee('The Legend of Zelda')
            ->assertSee('A legendary adventure.')
            ->assertSee('Adventure')
            ->assertSee('Nintendo Switch');
    }

    public function test_missing_game_returns_not_found(): void
    {
        config(['services.rawg.key' => 'test-key']);
        Http::fake([
            'https://api.rawg.io/api/games/999999*' => Http::response([], 404),
        ]);

        $this->get('/games/999999')->assertNotFound();
    }

    public function test_rawg_connection_failure_returns_service_unavailable(): void
    {
        config(['services.rawg.key' => 'test-key']);
        Http::fake([
            'https://api.rawg.io/api/games/4200*' => Http::failedConnection(),
        ]);

        $this->get('/games/4200')->assertStatus(503);
    }
}
