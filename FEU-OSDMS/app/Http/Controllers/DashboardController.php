<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\GateEntry;
use App\Models\Violation; // Added this import at the top
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. IntelliThings Metrics (Using the LostItem model)
        $totalAssets = LostItem::count();
        $pendingCount = LostItem::where('status', 'Pending Review')->count();

        // Status Breakdown
        $activeCount = LostItem::where('status', 'Active')->count();
        $claimedCount = LostItem::where('status', 'Claimed')->count();
        $matchedCount = LostItem::where('status', 'like', 'Matched%')->count();

        // Report Type Breakdown
        $lostCount = LostItem::where('report_type', 'Lost')->count();
        $foundCount = LostItem::where('report_type', 'Found')->count();

        // 2. Gate Entry Violations
        // We completely removed the old grouping math. Now it just counts the official active tickets!
        $activeViolations = Violation::where('status', 'Active')->count();

        // Academic Info
        $sy = '2025-2026';
        $semester = '2nd Semester';

        return view('dashboard', compact(
            'totalAssets', 'pendingCount', 'activeCount', 'claimedCount',
            'matchedCount', 'lostCount', 'foundCount', 'activeViolations',
            'sy', 'semester'
        ));
    }
}
