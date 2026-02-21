<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentReportController extends Controller
{
    public function index(Request $request)
    {
        $query = IncidentReport::query();

        if ($search = $request->input('search')) {
            $query->where('reporter_name', 'LIKE', "%{$search}%")
                  ->orWhere('incident_location', 'LIKE', "%{$search}%")
                  ->orWhere('incident_category', 'LIKE', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $incidents = $query->latest()->get();
        return view('incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('incidents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string',
            'reporter_email' => 'nullable|email',
            'reporter_affiliation' => 'nullable|string',
            'incident_date' => 'required|date',
            'incident_location' => 'required|string',
            'incident_category' => 'required|string',
            'severity' => 'required|string',
            'description' => 'required|string',
            'evidence' => 'nullable|image|max:5120' // Max 5MB
        ]);

        if ($request->hasFile('evidence')) {
            $validated['evidence_path'] = $request->file('evidence')->store('evidence', 'public');
        }

        unset($validated['evidence']);
        $validated['status'] = 'Pending Review';

        IncidentReport::create($validated);
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

    public function update(Request $request, IncidentReport $incident)
    {
        $incident->update([
            'status' => $request->status,
            'action_taken' => $request->action_taken
        ]);

        return redirect()->route('incidents.show', $incident)->with('success', 'Incident record updated successfully.');
    }

    public function destroy(IncidentReport $incident)
    {
        if ($incident->evidence_path) {
            Storage::disk('public')->delete($incident->evidence_path);
        }
        $incident->delete();
        return redirect()->route('incidents.index')->with('success', 'Incident record deleted.');
    }
}
