<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Real-time Counts pulled from your intelligence database
        $lostCount = LostItem::where('report_type', 'Lost')->count();
        $foundCount = LostItem::where('report_type', 'Found')->count();
        $activeViolations = 7;

        // Administrative Metadata
        $adminName = auth()->user()->name;
        $currentDate = now()->format('F d, Y');
        $semester = "2nd Semester";
        $sy = "S.Y. 2025-2026";

        return view('dashboard', compact(
            'lostCount', 'foundCount', 'activeViolations',
            'adminName', 'currentDate', 'semester', 'sy'
        ));
    }
}
