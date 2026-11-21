<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Les colonnes nom et slug n'existent pas dans publications.
    }

    public function down(): void
    {
        // Aucune colonne à restaurer.
    }
};
