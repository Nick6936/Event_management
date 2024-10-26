<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Music Concert',
                'description' => 'Join us for an evening of live music with various artists.',
                'date' => '2024-11-15',
                'location' => 'Basundhara Park',
                'category_id' => 1, 
            ],
            [
                'title' => 'Art Exhibition',
                'description' => 'Explore the latest artworks from local artists.',
                'date' => '2024-12-01',
                'location' => 'Art Gallery, Mahendrapool',
                'category_id' => 2, 
            ],
            [
                'title' => 'Food Festival',
                'description' => 'Experience a variety of cuisines from around the world.',
                'date' => '2025-01-20',
                'location' => 'Lakeside',
                'category_id' => 3, 
            ],
            [
                'title' => 'Children\'s Event',
                'description' => 'An event where children gather and play',
                'date' => '2025-02-10',
                'location' => 'Disneyland',
                'category_id' => 4, 
            ],
            [
                'title' => 'Community Clean-Up',
                'description' => 'Join us to clean up our local park and make a difference.',
                'date' => '2025-03-05',
                'location' => 'Children\'s Park, Parshyang',
                'category_id' => 5, 
            ],
        ]);
    }
}
