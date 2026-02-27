<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Required for the raw count math
use Barryvdh\DomPDF\Facade\Pdf;    // Required for the PDF generation

class ReportController extends Controller
{
    public function exportHotspots(Request $request)
    {
        $type = $request->type;

        $data = [
            'title' => $type == 'assets' ? 'Asset Recovery Hotspot Report' : 'Security Incident Hotspot Report',
            'date' => now()->format('M d, Y'),
            // We pull the data based on the button clicked ('assets' or 'incidents')
            'items' => $type == 'assets'
                ? \App\Models\LostItem::select('location_found as location', DB::raw('count(*) as total'))
                    ->whereNotNull('location_found')
                    ->groupBy('location')
                    ->get()
                : \App\Models\IncidentReport::select('incident_location as location', DB::raw('count(*) as total'))
                    ->groupBy('location')
                    ->get()
        ];

        // This matches the name of the blade file we created: reports/hotspots_pdf.blade.php
        $pdf = Pdf::loadView('reports.hotspots_pdf', $data);

        return $pdf->download('OSD-Hotspot-Report.pdf');
    }
}
