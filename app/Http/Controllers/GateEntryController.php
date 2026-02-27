<?php

namespace App\Http\Controllers;

use App\Models\GateEntry;
use App\Models\User;
use App\Models\Violation;
use App\Models\LostItem;
use Illuminate\Http\Request;

class GateEntryController extends Controller
{
    public function index()
    {
        // Automatically hides soft-deleted (archived) entries
        $entries = GateEntry::with('student')
            ->whereDate('created_at', today())
            ->latest()
            ->get()
            ->map(function ($entry) {
                // Calculate the student's lifetime 'Forgot ID' strikes to display to the guard
                if ($entry->reason === 'Forgot ID' && $entry->student) {
                    $entry->lifetime_strikes = GateEntry::where('student_id', $entry->student_id)
                        ->where('reason', 'Forgot ID')
                        ->count();
                } else {
                    $entry->lifetime_strikes = 0;
                }
                return $entry;
            });

        return view('gate.index', compact('entries'));
    }

    /**
     * VIEW THE ARCHIVES (New Method)
     */
    public function archived()
    {
        // Retrieves ONLY the soft-deleted gate entries
        $entries = GateEntry::onlyTrashed()
            ->with('student')
            ->latest('deleted_at')
            ->get();

        return view('gate.archives', compact('entries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_number' => 'required|exists:users,id_number',
            'reason' => 'required|in:Forgot ID,Lost ID,Visitor',
        ]);

        $student = User::where('id_number', $request->id_number)->first();

        // 1. Automated Strike Logic (Forgot ID)
        if ($request->reason === 'Forgot ID') {
            $strikeCount = GateEntry::where('student_id', $student->id)
                ->where('reason', 'Forgot ID')
                ->count();

            if ($strikeCount >= 2) {
                Violation::create([
                    'student_id' => $student->id,
                    'reporter_id' => auth()->id(),
                    'offense_type' => 'Excessive ID Passes (Automated)',
                    'description' => 'System Auto-Generated: Student reached maximum temporary gate passes.',
                    'status' => 'Active',
                    'academic_term' => '2nd Semester 2025-2026',
                ]);
                session()->flash('warning', 'SECURITY ALERT: Infraction recorded for ' . $student->name);
            }
        }

        // 2. Log Entry
        GateEntry::create([
            'student_id' => $student->id,
            'guard_id' => auth()->id(),
            'reason' => $request->reason,
            'time_in' => now(),
        ]);

        // 3. Semantic Matching (Lost ID Bridge to IntelliThings)
        if ($request->reason === 'Lost ID') {
            $potentialMatch = LostItem::where('report_type', 'Found')
                ->where('status', '!=', 'Claimed')
                ->where(function($query) use ($student) {
                    $query->where('description', 'like', '%' . $student->id_number . '%')
                          ->orWhere('description', 'like', '%' . $student->name . '%')
                          ->orWhere('item_category', 'like', '%ID%');
                })->first();

            if ($potentialMatch) {
                return redirect()->route('assets.show', $potentialMatch->id)
                    ->with('match_alert', "MATCH DETECTED: A found ID matching {$student->name} is in the system.");
            }
        }

        return redirect()->back()->with('success', 'Access Granted: ' . $student->name);
    }

    public function edit($id)
    {
        $entry = GateEntry::with('student')->findOrFail($id);
        return view('gate.edit', compact('entry'));
    }

    public function update(Request $request, $id)
    {
        $entry = GateEntry::findOrFail($id);
        $request->validate(['reason' => 'required|in:Forgot ID,Lost ID,Visitor']);
        $entry->update(['reason' => $request->reason]);
        return redirect()->route('gate.index')->with('success', 'Log updated.');
    }

    /**
     * ARCHIVE RECORD (Soft Delete)
     */
    public function destroy($id)
    {
        $entry = GateEntry::findOrFail($id);
        $entry->delete(); // This now moves it to the archive

        return redirect()->route('gate.index')->with('success', 'Log successfully moved to Archives.');
    }

    /**
     * RESTORE RECORD (New Method)
     */
    public function restore($id)
    {
        $entry = GateEntry::withTrashed()->findOrFail($id);
        $entry->restore();

        return redirect()->route('gate.archived')->with('success', 'Log restored to the active records.');
    }

    /**
     * PERMANENT DELETE (New Method)
     */
    public function forceDelete($id)
    {
        $entry = GateEntry::withTrashed()->findOrFail($id);
        $entry->forceDelete();

        return redirect()->route('gate.archived')->with('success', 'Log permanently deleted from the system.');
    }
}
