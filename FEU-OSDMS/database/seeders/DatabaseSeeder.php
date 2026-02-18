<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. The Super Admin (You/OSD Staff)
        User::create([
            'name' => 'OSD Admin',
            'email' => 'admin@feu.edu.ph',
            'password' => Hash::make('password'), // Simple password for testing
            'role' => 'admin',
            'id_number' => '20200001',
            'campus' => 'Manila',
        ]);

        // 2. The Security Guard (For Gate & Lost/Found)
        User::create([
            'name' => 'Kuya Guard',
            'email' => 'guard@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'guard',
            'id_number' => 'GUARD001',
            'campus' => 'Manila',
        ]);

        // 3. The Student (For Reporting Lost Items)
        User::create([
            'name' => 'Jose Jerry Tuazon',
            'email' => 'student@feu.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
            'id_number' => '202312345',
            'program_code' => 'BSIT',
            'campus' => 'Manila',
        ]);
    }
}