<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ViolationReportController extends Controller
{
    /**
     * Display a ranking of students based on violation count.
     * This automates the identification of high-risk students.
     */
    public function index()
    {
        // Get only students who have at least one violation, ranked by count
        $offenders = User::where('role', 'student')
            ->withCount('violations')
            ->having('violations_count', '>', 0)
            ->orderBy('violations_count', 'desc')
            ->get();

        return view('violations.report', compact('offenders'));
    }
}