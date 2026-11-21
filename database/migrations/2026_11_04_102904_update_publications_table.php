<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Les colonnes titre et contenu existent déjà
        // dans la migration initiale.
    }

    public function down(): void
    {
        // Aucune colonne à supprimer.
    }
};
