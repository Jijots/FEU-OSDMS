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

        // Path to the 'Found' photo uploaded by a Guard to compare against the 'Lost' report
        $foundImagePath = storage_path('app/public/samples/found_sample.jpg');
        $lostImagePath = storage_path('app/public/' . $lostItem->image_path);

        $python = env('PYTHON_PATH');
        $script = resource_path('scripts/visual_matcher.py');

        // Execute your OpenCV Visual Matcher script
        $result = Process::run([$python, $script, $lostImagePath, $foundImagePath]);

        $matchData = json_decode($result->output());

        return view('assets.show', [
            'item' => $lostItem,
            'match' => $matchData
        ]);
    }
}
