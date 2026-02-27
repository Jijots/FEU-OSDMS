<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\IncidentReport;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a few sample students
        $students = [
            ['name' => 'Juan Dela Cruz', 'id_number' => '2023-0001', 'email' => 'juan@example.edu', 'program_code' => 'BSIT'],
            ['name' => 'Maria Clara', 'id_number' => '2023-0002', 'email' => 'maria@example.edu', 'program_code' => 'BSCS'],
            ['name' => 'Jose Rizal', 'id_number' => '2023-0003', 'email' => 'jose@example.edu', 'program_code' => 'BSA'],
        ];

        foreach ($students as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'campus' => 'Manila'
                ])
            );

            // 2. Create a sample incident for each student
            IncidentReport::create([
                'student_id' => $user->id,
                'reporter_name' => 'Security Guard Reyes',
                'incident_date' => now()->subDays(rand(1, 10)),
                'incident_location' => 'Gate 3',
                'incident_category' => 'Unauthorized Entry',
                'severity' => 'Routine',
                'description' => 'Student forgotten ID and attempted to bypass turnstile.',
                'status' => 'Pending Review'
            ]);
        }
    }
}
