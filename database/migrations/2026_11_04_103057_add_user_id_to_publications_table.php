<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // user_id existe déjà dans create_publications_table.
    }

    public function down(): void
    {
        // Ne rien supprimer : user_id appartient à la migration initiale.
    }
};
