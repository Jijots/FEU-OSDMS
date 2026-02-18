<?php
namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller {
    public function index() {
        $violations = Violation::with('student')->latest()->paginate(10);
        return view('violations.index', compact('violations'));
    }

    public function create() {
        $students = User::where('role', 'student')->get();
        return view('violations.create', compact('students'));
    }

    public function store(Request $request) {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'offense_type' => 'required|string',
            'status' => 'required|string',
        ]);

        Violation::create([
            'student_id' => $request->student_id,
            'offense_type' => $request->offense_type,
            'status' => $request->status,
            'reporter_id' => Auth::user()->id, // Matches migration reporter_id
        ]);

        return redirect()->route('dashboard')->with('success', 'Violation recorded!');
    }
}