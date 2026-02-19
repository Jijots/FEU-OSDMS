<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class AssetMatchingController extends Controller
{
    public function index()
    {
        $items = LostItem::latest()->get();
        return view('assets.index', compact('items'));
    }

 public function compare(Request $request, $id)
    {
        $lostItem = LostItem::findOrFail($id);

        $foundImagePath = public_path('samples/found_hirono.jpg');
        $lostImagePath = public_path($lostItem->image_path);

        if (!file_exists($foundImagePath) || !file_exists($lostImagePath)) {
            return back()->with('error', 'Image files not found. Check public folder.');
        }

        // We use env('PYTHON_PATH') or default to 'python'
        $python = env('PYTHON_PATH', 'python');
        $script = resource_path('scripts/visual_matcher.py');

        // Run the process with timeout and robust error handling
        try {
            $result = Process::timeout(60)->run([$python, $script, $lostImagePath, $foundImagePath]);
        } catch (\Throwable $e) {
            Log::error('Matcher process exception: ' . $e->getMessage());
            return back()->with('error', 'Matcher execution failed.');
        }

        if ($result->failed() || empty($result->output())) {
            Log::error('Matcher failed', [
                'error_output' => $result->errorOutput(),
                'command' => "$python $script $lostImagePath $foundImagePath"
            ]);
            return back()->with('error', 'Asset matching failed. See logs for details.');
        }

        $output = $result->output();
        $decoded = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Matcher produced invalid JSON', ['output' => $output, 'json_error' => json_last_error_msg()]);
            $matchData = (object)[
                'visual_similarity' => 0,
                'breakdown' => 'Invalid matcher output',
                'error' => 'JSON Decode Error'
            ];
        } else {
            $matchData = (object)$decoded;
        }

        return view('assets.show', [
            'item' => $lostItem,
            'match' => $matchData
        ]);
    }
}
