<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\User;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index()
    {
        // For debugging/listing raw violations if needed
        return Violation::with('student')->latest()->get();
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('violations.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'offense_type' => 'required|string',
            'status' => 'required|string',
        ]);

        Violation::create([
            'student_id' => $request->student_id,
            'offense_type' => $request->offense_type,
            'status' => $request->status,
            'reporter_id' => auth()->id(), // FIXED: Matches your database column
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Violation recorded!');
    }
}
