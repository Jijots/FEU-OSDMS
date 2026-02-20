<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Real-time Counts based strictly on report type
        $lostCount = LostItem::where('report_type', 'Lost')->count();
        $foundCount = LostItem::where('report_type', 'Found')->count();

        $activeViolations = 7;
        $adminName = auth()->user()->name;
        $sy = "S.Y. 2025-2026";
        $semester = "2nd Semester";

        return view('dashboard', compact(
            'lostCount',
            'foundCount',
            'activeViolations',
            'adminName',
            'sy',
            'semester'
        ));
    }
}
