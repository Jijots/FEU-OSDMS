<?php

namespace App\Http\Controllers;

use App\Models\GateEntry;
use App\Models\User;
use Illuminate\Http\Request;

class GateEntryController extends Controller
{
    public function index()
    {
        // Displays the log history
        $entries = GateEntry::with('student')->whereDate('created_at', today())->latest()->get();
        return view('gate.index', compact('entries'));
    }

    public function store(Request $request)
    {
        // Logs a new entry
        $request->validate([
            'id_number' => 'required|exists:users,id_number',
            'reason' => 'required|string',
        ]);

        $student = User::where('id_number', $request->id_number)->first();

        GateEntry::create([
            'student_id' => $student->id,
            'guard_id' => auth()->id(),
            'reason' => $request->reason,
            'time_in' => now(),
        ]);

        return redirect()->back()->with('success', 'Gate entry logged for ' . $student->name);
    }
}
