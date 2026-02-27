<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\User;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    // Shows the form to create a new violation
    public function create()
    {
        // Get all students so we can put them in a searchable dropdown
        $students = User::where('role', 'student')->orderBy('name')->get();

        return view('violations.create', compact('students'));
    }

    // Saves the new violation to the database
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'offense_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // 2. Create the record
        Violation::create([
            'student_id' => $request->student_id,
            'reporter_id' => auth()->id(), // Automatically logs who filed it
            'offense_type' => $request->offense_type,
            'description' => $request->description,
            'status' => 'Active', // Default status for new reports
            'academic_term' => '2nd Semester 2025-2026',
        ]);

        // 3. Redirect back to the Hub with a success message
        return redirect()->route('violations.report')->with('success', 'Disciplinary report officially filed.');
    }

    // READ: View a specific case dossier
    public function show($id)
    {
        $violation = Violation::with(['student', 'reporter'])->findOrFail($id);
        return view('violations.show', compact('violation'));
    }

    // UPDATE PAGE: Show form to add findings and resolve case
    public function edit($id)
    {
        $violation = Violation::with('student')->findOrFail($id);
        return view('violations.edit', compact('violation'));
    }

    // UPDATE ACTION: Save the adjudication details
    public function update(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Active,Resolved,Dismissed',
            'findings' => 'nullable|string',
            'final_action' => 'nullable|string',
        ]);

        $violation->update([
            'status' => $request->status,
            'findings' => $request->findings,
            'final_action' => $request->final_action,
        ]);

        return redirect()->route('violations.show', $violation->id)->with('success', 'Case dossier updated successfully.');
    }

    // DELETE: Remove the infraction from the system
    public function destroy($id)
    {
        $violation = Violation::findOrFail($id);
        $violation->delete();

        return redirect()->route('violations.report')->with('success', 'Disciplinary record permanently deleted.');
    }

    // GENERATE PDF/PRINT: Notice to Explain
    public function generateNTE($id)
    {
        // We load the violation, the student it belongs to, and the officer who reported it
        $violation = Violation::with(['student', 'reporter'])->findOrFail($id);

        // We will return a special, blank print layout (no navbars, just the document)
        return view('violations.nte', compact('violation'));
    }
}
