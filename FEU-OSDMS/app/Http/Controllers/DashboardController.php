<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Violation;
use App\Models\GateEntry;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'studentCount' => User::where('role', 'student')->count(),
            'gateEntryCount' => GateEntry::whereDate('created_at', today())->count(),
            'pendingViolations' => Violation::where('status', 'Pending')->count(),
            'matchCount' => 5 // Placeholder for AI matches
        ]);
    }
}
