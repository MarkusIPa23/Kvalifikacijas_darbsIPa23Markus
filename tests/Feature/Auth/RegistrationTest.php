<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_registration_preserves_anonymous_favorites(): void
    {
        $favoriteGames = [
            '42' => [
                'id' => 42,
                'title' => 'Saved game',
            ],
        ];

        $this->withSession(['favorite_games' => $favoriteGames])
            ->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $this->assertSame(
            $favoriteGames,
            User::where('email', 'test@example.com')->firstOrFail()->favorite_games,
        );
    }

    public function test_logged_in_user_sees_their_name_in_the_navigation(): void
    {
        $user = User::factory()->create([
            'name' => 'Anna Andersone',
            'email' => 'anna@example.com',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
        $response->assertSee('Anna Andersone');
        $response->assertDontSee('Mans profils');
        $response->assertDontSee('Dashboard');
    }
}
