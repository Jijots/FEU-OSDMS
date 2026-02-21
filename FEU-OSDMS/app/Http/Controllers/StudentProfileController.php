<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentProfileController extends Controller
{
    /**
     * Display the Student Directory with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = User::where('role', 'student')
            ->when($search, function ($query, $search) {
                return $query->where('id_number', 'like', "%{$search}%")
                             ->orWhere('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('students.index', compact('students', 'search'));
    }

    /**
     * BULK CSV IMPORT FEATURE
     * Defends against manual data entry for large university populations.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->path(), 'r');

        // Skip the header row
        fgetcsv($handle);

        $importedCount = 0;

        // Loop through the CSV rows
        while (($data = fgetcsv($handle)) !== FALSE) {
            // Ensure the row has enough columns (Name, ID, Email, Program, Specialization)
            if (count($data) >= 3) {
                User::updateOrCreate(
                    ['email' => trim($data[2])], // Unique identifier (Email)
                    [
                        'name' => trim($data[0]),
                        'id_number' => trim($data[1]),
                        'program_code' => trim($data[3] ?? 'N/A'),
                        'specialization' => trim($data[4] ?? 'General'),
                        'role' => 'student',
                        'password' => Hash::make(trim($data[1])), // Default password is their ID number
                    ]
                );
                $importedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('students.index')->with('success', "System initialized: $importedCount student records successfully imported.");
    }

    /**
     * Show a specific student's profile and disciplinary history.
     */
    public function show($student_id)
    {
        $student = User::with(['violations', 'lostItems'])->findOrFail($student_id);
        return view('students.show', compact('student'));
    }
}
