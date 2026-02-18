<?php

namespace App\Http\Controllers;

use App\Models\GateEntry;
use Illuminate\Http\Request;

class GateEntryController extends Controller
{
    public function index()
    {
        $entries = GateEntry::with('student')->latest()->get();
        return view('gate.index', compact('entries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'reason' => 'required|string',
        ]);

        GateEntry::create([
            'student_id' => $request->student_id,
            'guard_id' => auth()->id(),
            'reason' => $request->reason,
            'time_in' => now(),
        ]);

        return redirect()->back()->with('success', 'Entry logged!');
    }
}
