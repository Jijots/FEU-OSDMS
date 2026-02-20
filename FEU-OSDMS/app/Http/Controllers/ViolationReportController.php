<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationReportController extends Controller
{
    public function index()
    {
        // Fetch all violations, including the student and reporter data, newest first
        $violations = Violation::with(['student', 'reporter'])->latest()->get();

        // Pass the $violations variable to the report.blade.php view
        return view('violations.report', compact('violations'));
    }
}
