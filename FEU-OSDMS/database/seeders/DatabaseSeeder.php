<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LostItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        User::create([
            'name' => 'OSD Admin',
            'email' => 'admin@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'id_number' => '20200001',
            'campus' => 'Manila',
        ]);

        // 2. Guard Account
        User::create([
            'name' => 'Kuya Guard',
            'email' => 'guard@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'guard',
            'id_number' => 'GUARD001',
            'campus' => 'Manila',
        ]);

        // 3. Student Account
        User::create([
            'name' => 'Jose Jerry Tuazon',
            'email' => 'student@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
            'id_number' => '202312345',
            'program_code' => 'BSIT',
            'campus' => 'Manila',
        ]);

        // 4. THE HIRONO FIGURE (This puts the image in the database)
        LostItem::create([
            'founder_id' => 2, // The Guard (ID 2)
            'item_category' => 'Hirono King Figure',
            'description' => 'Pop Mart Hirono Little Mischief Series, King version with crown.',
            'location_found' => 'Study Area 4th Floor',
            'image_path' => 'lost_hirono.jpg', // MUST match the filename in Step 1
            'is_claimed' => false,
        ]);
    }
}
