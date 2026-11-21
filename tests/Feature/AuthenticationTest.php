<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_visiteur_peut_creer_un_compte(): void
    {
        $response = $this->post('/inscription', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('accueil'));

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'auteur',
        ]);

        $this->assertAuthenticated();
    }

    public function test_une_connexion_avec_un_mauvais_mot_de_passe_est_refusee(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/connexion', [
            'email' => 'test@example.com',
            'password' => 'mauvaismotdepasse',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
