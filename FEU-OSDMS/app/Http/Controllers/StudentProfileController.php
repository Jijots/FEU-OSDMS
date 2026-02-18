<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    /**
     * Display the Student Directory with search functionality.
     * This fulfills the 'Efficiency' goal by replacing manual NetSuite searches.
     */
    public function index(Request $request)
    {
        // Get the search term from the URL (e.g., ?search=Jose)
        $search = $request->input('search');

        // Fetch students, filtering by Name or ID Number if a search term exists
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
     * Show a specific student's profile and disciplinary history.
     * Use $student_id to match the {student_id} wildcard in web.php.
     */
    public function show($student_id) 
    {
        // Eager load violations and lost items to show the 'Digitized Record'
        $student = User::with(['violations', 'lostItems'])->findOrFail($student_id);

        return view('students.show', compact('student'));
    }
}