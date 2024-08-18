<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Football',
                'description' => 'News and updates about football matches, players, and events.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Basketball',
                'description' => 'Latest basketball news, including game results and player statistics.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fitness',
                'description' => 'Articles on fitness tips, workouts, and health advice.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Nutrition',
                'description' => 'Guides and advice on nutrition, diet plans, and healthy eating.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Events',
                'description' => 'Information about upcoming sports events and club activities.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        

        Category::insert($categories);    }
}
