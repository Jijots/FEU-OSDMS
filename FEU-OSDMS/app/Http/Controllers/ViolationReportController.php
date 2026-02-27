<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationReportController extends Controller
{
    public function index()
    {
        // Automatically fetches all ACTIVE (non-archived) violations
        $violations = Violation::with(['student', 'reporter'])->latest()->get();

        // Pass the $violations variable to the report.blade.php view
        return view('violations.report', compact('violations'));
    }

    /**
     * ARCHIVE RECORD (Soft Delete)
     */
    public function destroy($id)
    {
        $violation = Violation::findOrFail($id);

        // This now safely archives the record instead of wiping it
        $violation->delete();

        return redirect()->route('violations.report')->with('success', 'Disciplinary record securely moved to the Archives.');
    }
}
