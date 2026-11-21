<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_visiteur_peut_consulter_la_liste_des_publications(): void
    {
        $auteur = User::factory()->create();

        $categorie = Categorie::create([
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        Publication::create([
            'titre' => 'Mon premier podcast',
            'contenu' => 'Voici un contenu suffisamment long pour le test.',
            'categorie_id' => $categorie->id,
            'user_id' => $auteur->id,
        ]);

        $response = $this->getJson('/api/publications');

        $response->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_un_visiteur_non_authentifie_ne_peut_pas_creer_une_publication(): void
    {
        $response = $this->postJson('/api/publications', [
            'titre' => 'Nouvelle publication',
            'contenu' => 'Voici un contenu suffisamment long pour le test.',
        ]);

        $response->assertUnauthorized();
    }
}
