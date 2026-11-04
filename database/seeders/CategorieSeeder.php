<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insertOrIgnore([
            [
                'nom' => 'Image',
                'slug' => 'image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Vidéo',
                'slug' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Audio',
                'slug' => 'audio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
