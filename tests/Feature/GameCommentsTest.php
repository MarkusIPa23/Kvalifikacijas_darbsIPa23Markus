<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_user_can_leave_a_comment_on_a_game(): void
    {
        $this->fakeRawgGame();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/games?search=zelda')
            ->post('/games/4200/comments', [
                'body' => 'This one is a masterpiece.',
                'game_title' => 'The Legend of Zelda',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/games?search=zelda');

        $this->assertDatabaseHas('game_comments', [
            'game_id' => '4200',
            'user_id' => $user->id,
            'body' => 'This one is a masterpiece.',
        ]);
    }

    public function test_guest_cannot_leave_a_comment_on_a_game(): void
    {
        $response = $this
            ->from('/games?search=zelda')
            ->post('/games/4200/comments', [
                'body' => 'This one is a masterpiece.',
                'game_title' => 'The Legend of Zelda',
            ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_cannot_contain_only_whitespace(): void
    {
        $this->fakeRawgGame();
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('/games/4200/comments', ['body' => '   '])
            ->assertSessionHasErrors('body');

        $this->assertDatabaseCount('game_comments', 0);
    }

    public function test_comment_requires_a_game_from_rawg(): void
    {
        config(['services.rawg.key' => 'test-key']);
        Http::fake([
            'https://api.rawg.io/api/games/999999*' => Http::response([], 404),
        ]);
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('/games/999999/comments', ['body' => 'Not a real game'])
            ->assertSessionHasErrors('gameId');

        $this->assertDatabaseCount('game_comments', 0);
    }

    public function test_rawg_outage_is_not_reported_as_a_missing_game(): void
    {
        config(['services.rawg.key' => 'test-key']);
        Http::fake([
            'https://api.rawg.io/api/games/4200*' => Http::failedConnection(),
        ]);
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('/games/4200/comments', ['body' => 'A useful comment'])
            ->assertStatus(503);

        $this->assertDatabaseCount('game_comments', 0);
    }

    public function test_all_registered_users_can_see_comments_on_the_games_page(): void
    {
        config([
            'services.rawg.key' => 'test-key',
            'services.rawg.url' => 'https://api.rawg.io/api',
        ]);
        Http::fake([
            'https://api.rawg.io/api/games*' => Http::response([
                'count' => 1,
                'results' => [[
                    'id' => 4200,
                    'name' => 'The Legend of Zelda',
                    'slug' => 'the-legend-of-zelda',
                    'genres' => [['name' => 'Adventure']],
                    'platforms' => [],
                ]],
            ]),
        ]);

        $author = User::factory()->create(['name' => 'Comment author']);
        $viewer = User::factory()->create(['name' => 'Another player']);

        $author->gameComments()->create([
            'game_id' => '4200',
            'game_title' => 'The Legend of Zelda',
            'body' => 'Everyone should try this game.',
        ]);

        $this
            ->actingAs($viewer)
            ->get('/games?search=zelda')
            ->assertOk()
            ->assertSee('Everyone should try this game.')
            ->assertSee('Comment author');
    }

    public function test_guests_do_not_see_game_comments(): void
    {
        $author = User::factory()->create();

        $author->gameComments()->create([
            'game_id' => '4200',
            'game_title' => 'The Legend of Zelda',
            'body' => 'Members-only comment.',
        ]);

        $this
            ->get('/games')
            ->assertDontSee('Members-only comment.');
    }

    private function fakeRawgGame(): void
    {
        config(['services.rawg.key' => 'test-key']);
        Http::fake([
            'https://api.rawg.io/api/games/4200*' => Http::response(['id' => 4200]),
        ]);
    }
}
