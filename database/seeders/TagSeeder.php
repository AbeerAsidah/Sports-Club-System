<?php

namespace Database\Seeders;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->delete();
        $tags=[
            [
                'name'=> 'do_not_do!',
                'color'=>'red',
                'created_at' => now(),
                'updated_at' => now()
               
            ],
            [
                'name'=> 'advice',
                'color'=>'blue',
                'created_at' => now(),
                'updated_at' => now()
              

            ],
         
            [
                'name' => 'Training',
                'color' => 'green',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Match',
                'color' => 'blue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Injury',
                'color' => 'red',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nutrition',
                'color' => 'orange',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Event',
                'color' => 'purple',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Achievement',
                'color' => 'gold',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Tag::insert($tags);    }
}
