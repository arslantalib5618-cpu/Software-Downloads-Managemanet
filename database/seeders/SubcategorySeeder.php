<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;


class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [

            'windows' => [
                'Antivirus & Security',
                'Audio & Music',
                'Developer Tools',
                'Backup & Recovery',
                'Download Managers',
                'Educational & Business',
                'Web Browsers',
                'Graphics & Design',
                'Video Editors',
                'Web & Programming' ,

            ],

            'macos' => [
                'Backup & Restore',
                'Data Recovery',
                'Audio & Music',
                'Graphic Editors',
                'Office & Pdf',
                'Web & Programming',
                'Developer Tools',
            ],

            'android' => [
                'Antivirus & Security',
                'Communication',
                'Fitness & Health',
                'Mobile Browsers',
                'Video Editors',
            ],

            'games' => [
                'Action',
                'Adventure',
                'Racing',
                'Sports',
                'casual',
            ],

        
        ];

        foreach ($subcategories as $categorySlug => $items) {

            $category = Category::where('slug', $categorySlug)->first();

            foreach ($items as $name) {

                Subcategory::create([
    'category_id' => $category->id,
    'name' => $name,
]);

            }
        }
    }
}