<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Windows',
            'slug' => 'windows',
        ]);

        Category::create([
            'name' => 'MacOS',
            'slug' => 'macos',
        ]);

        Category::create([
            'name' => 'Android',
            'slug' => 'android',
        ]);

        Category::create([
            'name' => 'Games',
            'slug' => 'games',
        ]);

        Category::create([
            'name' => 'Utilities',
            'slug' => 'utilities',
        ]);
    }
}