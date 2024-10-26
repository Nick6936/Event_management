<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Margin Top',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => bcrypt('password123'),
            ],
        ]);
    }
}