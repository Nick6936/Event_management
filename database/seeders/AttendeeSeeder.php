<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attendees')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'event_id' => 1, 
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'event_id' => 2, 
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'event_id' => 3, 
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'event_id' => 4, 
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie.davis@example.com',
                'event_id' => 5, 
            ],
        ]);
    }
}
