<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RandomGameTest extends TestCase
{
    public function test_it_displays_a_game_from_the_free_to_game_api(): void
    {
        Cache::forget('freetogame.games');

        Http::fake([
            'https://www.freetogame.com/api/games' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Space Shooter',
                    'thumbnail' => 'https://example.com/space-shooter.jpg',
                    'short_description' => 'Ātra kosmosa spēle.',
                    'game_url' => 'https://example.com/space-shooter',
                    'genre' => 'Shooter',
                    'platform' => 'PC (Windows)',
                    'release_date' => '2024-01-15',
                ],
                [
                    'id' => 2,
                    'title' => 'Browser Strategy',
                    'thumbnail' => 'https://example.com/browser-strategy.jpg',
                    'short_description' => 'Stratēģijas spēle pārlūkā.',
                    'game_url' => 'https://example.com/browser-strategy',
                    'genre' => 'Strategy',
                    'platform' => 'Web Browser',
                    'release_date' => '2018-02-01',
                ],
            ]),
        ]);

        $response = $this->get('/random?genre=shooter&platform=pc&year=2021-2026');

        $response
            ->assertOk()
            ->assertSee('Space Shooter')
            ->assertSee('Ātra kosmosa spēle.');

        Http::assertSent(fn (Request $request): bool => $request->url() === 'https://www.freetogame.com/api/games');
    }

    public function test_it_searches_games_by_title(): void
    {
        Cache::forget('freetogame.games');

        Http::fake([
            'https://www.freetogame.com/api/games' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Space Shooter',
                    'thumbnail' => 'https://example.com/space-shooter.jpg',
                    'short_description' => 'Ātra kosmosa spēle.',
                    'game_url' => 'https://example.com/space-shooter',
                    'genre' => 'Shooter',
                    'platform' => 'PC (Windows)',
                    'release_date' => '2024-01-15',
                ],
                [
                    'id' => 2,
                    'title' => 'Browser Strategy',
                    'thumbnail' => 'https://example.com/browser-strategy.jpg',
                    'short_description' => 'Stratēģijas spēle pārlūkā.',
                    'game_url' => 'https://example.com/browser-strategy',
                    'genre' => 'Strategy',
                    'platform' => 'Web Browser',
                    'release_date' => '2018-02-01',
                ],
            ]),
        ]);

        $response = $this->get('/random?search=browser');

        $response
            ->assertOk()
            ->assertSee('Atrastas 1 spēles')
            ->assertSee('Browser Strategy')
            ->assertDontSee('Space Shooter');
    }
}
