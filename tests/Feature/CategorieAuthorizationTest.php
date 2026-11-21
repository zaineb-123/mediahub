<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_administrateur_peut_creer_une_categorie(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/categories', [
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);
    }

    public function test_un_auteur_ne_peut_pas_creer_une_categorie(): void
    {
        $auteur = User::factory()->create([
            'role' => 'auteur',
        ]);

        $response = $this->actingAs($auteur)->post('/categories', [
            'nom' => 'Musique',
            'slug' => 'musique',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('categories', [
            'nom' => 'Musique',
            'slug' => 'musique',
        ]);
    }
}
