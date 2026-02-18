<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function checkVisualMatch(Request $request)
    {
        // 1. Validate Upload
        $request->validate([
            'lost_image' => 'required|image',
            'found_image' => 'required|image',
        ]);

        // 2. Save Images Temporarily
        $lostPath = $request->file('lost_image')->store('temp');
        $foundPath = $request->file('found_image')->store('temp');

        // 3. Get Full Paths for Python
        $absLost = storage_path('app/' . $lostPath);
        $absFound = storage_path('app/' . $foundPath);

        $scriptPath = resource_path('scripts/visual_matcher.py');
        $python = env('PYTHON_PATH', 'python');

        // 4. Run Python Script
        $result = Process::run([$python, $scriptPath, $absLost, $absFound]);

        // 5. Cleanup
        Storage::delete([$lostPath, $foundPath]);

        // 6. Return Result
        if ($result->failed()) {
            return response()->json(['error' => $result->errorOutput()], 500);
        }

        return response()->json(json_decode($result->output()));
    }
}