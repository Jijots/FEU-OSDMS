<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentReportController extends Controller
{
    /**
     * DISPLAY ACTIVE REPORTS
     */
    public function index(Request $request)
    {
        // Eloquent automatically hides soft-deleted items here
        $query = IncidentReport::query();

        // 1. Search Logic
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reporter_name', 'LIKE', "%{$search}%")
                    ->orWhere('incident_location', 'LIKE', "%{$search}%")
                    ->orWhere('incident_category', 'LIKE', "%{$search}%");
            });
        }

        // 2. Dashboard Filter Logic (Matches dashboard clicks)
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $incidents = $query->latest()->get();
        return view('incidents.index', compact('incidents'));
    }

    /**
     * VIEW THE ARCHIVES (Retrieves only soft-deleted items)
     */
    public function archived(Request $request)
    {
        $query = IncidentReport::onlyTrashed();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reporter_name', 'LIKE', "%{$search}%")
                    ->orWhere('incident_location', 'LIKE', "%{$search}%")
                    ->orWhere('incident_category', 'LIKE', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $incidents = $query->latest('deleted_at')->get();
        return view('incidents.archives', compact('incidents'));
    }

    public function create()
    {
        return view('incidents.create');
    }

    /**
     * STORE NEW REPORT
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id', // NEW: Must select a student
            'reporter_name' => 'required|string',
            // ... rest of your validation ...
        ]);

        if ($request->hasFile('evidence')) {
            $validated['evidence_path'] = $request->file('evidence')->store('evidence', 'public');
        }

        $validated['status'] = 'Pending Review';

        IncidentReport::create($validated); // This will now save the student_id

        return redirect()->route('incidents.index')->with('success', 'Incident report successfully logged.');
    }

    public function show(IncidentReport $incident)
    {
        return view('incidents.show', compact('incident'));
    }

    public function edit(IncidentReport $incident)
    {
        return view('incidents.edit', compact('incident'));
    }

    /**
     * UPDATE STATUS OR ACTION TAKEN
     */
    public function update(Request $request, IncidentReport $incident)
    {
        $incident->update([
            'status' => $request->status,
            'action_taken' => $request->action_taken
        ]);

        return redirect()->route('incidents.show', $incident)->with('success', 'Incident record updated successfully.');
    }

    /**
     * ARCHIVE RECORD (Soft Delete)
     */
    public function destroy(IncidentReport $incident)
    {
        // Evidence is preserved in archives for potential restoration
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incident record securely moved to the Archives.');
    }

    /**
     * RESTORE RECORD FROM ARCHIVES
     */
    public function restore($id)
    {
        $incident = IncidentReport::withTrashed()->findOrFail($id);
        $incident->restore();

        return redirect()->route('incidents.archived')->with('success', 'Incident record restored to active status.');
    }

    /**
     * PERMANENT DELETE (Wipes DB and physical storage)
     */
    public function forceDelete($id)
    {
        $incident = IncidentReport::withTrashed()->findOrFail($id);

        // Delete physical photo file from storage disk
        if ($incident->evidence_path) {
            Storage::disk('public')->delete($incident->evidence_path);
        }

        $incident->forceDelete();

        return redirect()->route('incidents.archived')->with('success', 'Incident record and evidence permanently expunged.');
    }
}
