
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('publications', function (Blueprint $table) {
    $table->id();
    $table->string('titre');
    $table->longText('contenu');
    $table->foreignId('categorie_id')->constrained('categories');
    $table->foreignId('user_id')->constrained('users');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
