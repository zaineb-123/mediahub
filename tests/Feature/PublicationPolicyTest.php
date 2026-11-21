<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_auteur_peut_modifier_sa_propre_publication(): void
    {
        $auteur = User::factory()->create([
            'role' => 'auteur',
        ]);

        $categorie = Categorie::create([
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        $publication = Publication::create([
            'titre' => 'Ancien titre',
            'contenu' => 'Voici un contenu suffisamment long pour le test.',
            'categorie_id' => $categorie->id,
            'user_id' => $auteur->id,
        ]);

        $response = $this->actingAs($auteur)->get(
            route('contenus.edit', $publication)
        );

        $response->assertStatus(200);
    }

    public function test_un_auteur_ne_peut_pas_modifier_la_publication_d_un_autre(): void
    {
        $proprietaire = User::factory()->create([
            'role' => 'auteur',
        ]);

        $autreAuteur = User::factory()->create([
            'role' => 'auteur',
        ]);

        $categorie = Categorie::create([
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        $publication = Publication::create([
            'titre' => 'Publication privée',
            'contenu' => 'Voici un contenu suffisamment long pour le test.',
            'categorie_id' => $categorie->id,
            'user_id' => $proprietaire->id,
        ]);

        $response = $this->actingAs($autreAuteur)->get(
            route('contenus.edit', $publication)
        );

        $response->assertForbidden();
    }
}
