<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        // 4. Run Python Script with timeout and ensure cleanup
        try {
            $result = Process::timeout(60)->run([$python, $scriptPath, $absLost, $absFound]);
        } catch (\Throwable $e) {
            Storage::delete([$lostPath, $foundPath]);
            Log::error('Matcher exception: ' . $e->getMessage());
            return response()->json(['error' => 'Matcher execution failed.'], 500);
        } finally {
            // Ensure temporary files are removed even on failure
            Storage::delete([$lostPath, $foundPath]);
        }

        if ($result->failed()) {
            Log::error('Matcher failed', ['error_output' => $result->errorOutput()]);
            return response()->json(['error' => trim($result->errorOutput()) ?: 'Matcher failed'], 500);
        }

        $output = $result->output();
        $decoded = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Invalid JSON from matcher', ['output' => $output, 'json_error' => json_last_error_msg()]);
            return response()->json(['error' => 'Invalid JSON from matcher'], 500);
        }

        return response()->json($decoded);
    }
}
