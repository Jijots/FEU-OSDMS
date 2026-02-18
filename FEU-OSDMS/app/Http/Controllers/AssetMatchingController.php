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

        // FIXED: Use public_path() because your files are in the 'public' folder
        $foundImagePath = public_path('samples/found_hirono.jpg');
        $lostImagePath = public_path($lostItem->image_path);

        // Debugging: Check if files actually exist before running Python
        if (!file_exists($foundImagePath) || !file_exists($lostImagePath)) {
            return back()->with('error', 'Image files not found. Check public folder.');
        }

        $python = env('PYTHON_PATH', 'python');
        $script = resource_path('scripts/visual_matcher.py');

        $result = Process::run([$python, $script, $lostImagePath, $foundImagePath]);

        $output = $result->output();
        $matchData = json_decode($output) ?? (object)['match_score' => 0, 'keypoints' => []];

        return view('assets.show', [
            'item' => $lostItem,
            'match' => $matchData
        ]);
    }
}
