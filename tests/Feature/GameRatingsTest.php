<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameRatingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_user_can_rate_a_game_from_one_to_ten(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/games?search=zelda')
            ->post('/games/4200/ratings', [
                'rating' => 8,
                'game_title' => 'The Legend of Zelda',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/games?search=zelda');

        $this->assertDatabaseHas('game_ratings', [
            'game_id' => '4200',
            'user_id' => $user->id,
            'rating' => 8,
        ]);
    }

    public function test_registered_user_can_update_their_game_rating(): void
    {
        $user = User::factory()->create();
        $user->gameRatings()->create([
            'game_id' => '4200',
            'game_title' => 'The Legend of Zelda',
            'rating' => 4,
        ]);

        $this
            ->actingAs($user)
            ->post('/games/4200/ratings', ['rating' => 9])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('game_ratings', 1);
        $this->assertDatabaseHas('game_ratings', [
            'game_id' => '4200',
            'user_id' => $user->id,
            'rating' => 9,
        ]);
    }

    public function test_guest_cannot_rate_a_game(): void
    {
        $this
            ->from('/games?search=zelda')
            ->post('/games/4200/ratings', ['rating' => 8])
            ->assertRedirect('/login');
    }

    public function test_rating_must_be_between_one_and_ten(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('/games/4200/ratings', ['rating' => 11])
            ->assertSessionHasErrors('rating');

        $this->assertDatabaseCount('game_ratings', 0);
    }
}
