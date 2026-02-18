<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

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

        // 1. Get the path to the 'Found' photo (Simulating the camera scan)
        $foundImagePath = storage_path('app/public/samples/found_hirono.jpg'); //

        // 2. Get the path to the 'Lost' photo (From the database)
        $lostImagePath = storage_path('app/public/' . $lostItem->image_path);

        // 3. Setup Python Script
        $python = env('PYTHON_PATH', 'python'); // Defaults to 'python' if .env is missing it
        $script = resource_path('scripts/visual_matcher.py');

        // 4. Run the AI Comparison
        $result = Process::run([$python, $script, $lostImagePath, $foundImagePath]);

        // 5. Decode results
        $output = $result->output();
        $matchData = json_decode($output) ?? (object)['match_score' => 0, 'keypoints' => []];

        return view('assets.show', [
            'item' => $lostItem,
            'match' => $matchData
        ]);
    }
}
