<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LostItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Account - Full access to Analytics and IntelliThings
        User::create([
            'name' => 'OSD Admin',
            'email' => 'admin@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'id_number' => '20200001',
            'campus' => 'Manila',
        ]);

        // 2. Guard Account - Primary user for reporting lost items
        User::create([
            'name' => 'Kuya Guard',
            'email' => 'guard@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'guard',
            'id_number' => 'GUARD001',
            'campus' => 'Manila',
        ]);

        // 3. Student Account - For testing search and violation rankings
        User::create([
            'name' => 'Jose Jerry Tuazon',
            'email' => 'student@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
            'id_number' => '202312345',
            'program_code' => 'BSIT',
            'campus' => 'Manila',
        ]);

        // 4. Sample Lost Item - Includes the new Status and Date Lost fields
        LostItem::create([
            'founder_id' => 2, // References 'Kuya Guard' (ID 2)
            'item_category' => 'Hirono King Figure',
            'description' => 'Pop Mart Hirono Little Mischief Series, King version with crown.',
            'location_found' => 'Study Area 4th Floor',
            'date_lost' => now()->subDays(2), // Automatically sets the date to 2 days ago
            'status' => 'Lost',
            'image_path' => 'lost_hirono.jpg', // Ensure this file exists in public/ or storage/app/public/
            'is_claimed' => false,
        ]);
    }
}
