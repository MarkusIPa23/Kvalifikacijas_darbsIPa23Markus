<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameCatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_applies_valid_filters_and_displays_matching_games(): void
    {
        $this->fakeRawg([
            'count' => 1,
            'results' => [$this->rawgGame()],
        ]);

        $this->get('/games?search=zelda&genre=action&platform=pc&year=2020&ordering=-rating')
            ->assertOk()
            ->assertSee('The Legend of Zelda');

        Http::assertSent(function (Request $request): bool {
            parse_str((string) parse_url($request->url(), PHP_URL_QUERY), $query);

            return ($query['search'] ?? null) === 'zelda'
                && ($query['genres'] ?? null) === 'action'
                && ($query['platforms'] ?? null) === '4'
                && ($query['dates'] ?? null) === '2020-01-01,2020-12-31'
                && ($query['ordering'] ?? null) === '-rating';
        });
    }

    public function test_search_displays_an_empty_state_when_no_games_match(): void
    {
        $this->fakeRawg(['count' => 0, 'results' => []]);

        $this->get('/games?search=not-a-real-game')
            ->assertOk()
            ->assertSee('Pēc šiem kritērijiem spēles netika atrastas.');
    }

    public function test_search_displays_a_recoverable_message_when_rawg_is_unavailable(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://api.rawg.io/api/games*' => Http::failedConnection(),
        ]);

        $this->get('/games')
            ->assertOk()
            ->assertSee('Pašlaik nevarējām saņemt spēļu sarakstu.');
    }

    public function test_invalid_filter_is_rejected_before_calling_rawg(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::preventStrayRequests();

        $this->get('/games?genre=not-a-genre')
            ->assertSessionHasErrors('genre');

        Http::assertNothingSent();
    }

    public function test_random_page_displays_a_game_from_the_catalogue(): void
    {
        $this->fakeRawg([
            'count' => 1,
            'results' => [$this->rawgGame()],
        ]);

        $this->get('/random')
            ->assertOk()
            ->assertSee('The Legend of Zelda');
    }

    public function test_guest_can_save_a_valid_favorite_in_their_session(): void
    {
        $response = $this
            ->from('/')
            ->post('/favorites/toggle', $this->favoriteData());

        $response
            ->assertRedirect('/')
            ->assertSessionHas('favorite_games.4200.title', 'The Legend of Zelda');
    }

    public function test_favorite_rejects_overlong_user_input(): void
    {
        $data = $this->favoriteData();
        $data['title'] = str_repeat('x', 256);

        $response = $this
            ->from('/')
            ->post('/favorites/toggle', $data);

        $response
            ->assertSessionHasErrors('title')
            ->assertSessionMissing('favorite_games');
    }

    /** @param array<string, mixed> $response */
    private function fakeRawg(array $response): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'https://api.rawg.io/api/games*' => Http::response($response),
        ]);
    }

    /** @return array<string, mixed> */
    private function rawgGame(): array
    {
        return [
            'id' => 4200,
            'name' => 'The Legend of Zelda',
            'slug' => 'the-legend-of-zelda',
            'genres' => [['name' => 'Action']],
            'platforms' => [['platform' => ['name' => 'PC']]],
        ];
    }

    /** @return array<string, mixed> */
    private function favoriteData(): array
    {
        return [
            'id' => 4200,
            'title' => 'The Legend of Zelda',
            'thumbnail' => 'https://example.com/zelda.jpg',
            'url' => 'https://rawg.io/games/the-legend-of-zelda',
            'genre' => 'Adventure',
            'platform' => 'Nintendo Switch',
            'releaseDate' => '1986-02-21',
            'rating' => 4.5,
            'description' => 'A classic adventure game.',
        ];
    }
}
