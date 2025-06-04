<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slide;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 3 slide default
        for ($i = 1; $i <= 3; $i++) {
            Slide::firstOrCreate(
                ['position' => $i],
                ['image_path' => null] // Akan menggunakan gambar default dari asset
            );
        }
    }
}