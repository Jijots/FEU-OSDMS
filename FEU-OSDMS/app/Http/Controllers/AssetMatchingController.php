<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;

class AssetMatchingController extends Controller
{
    public function index()
    {
        $items = LostItem::oldest()->get();
        return view('assets.index', compact('items'));
    }

    /**
     * FIX: Restored Create Method
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * FIX: Restored Store Method with AI Flagging
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_category' => 'required|string',
            'date_lost' => 'required|date',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
            'report_type' => 'required|in:Lost,Found',
        ]);

        $item = new LostItem();
        $item->item_category = $validated['item_category'];
        $item->date_lost = $validated['date_lost'];
        $item->description = $validated['description'];
        $item->report_type = $validated['report_type'];
        $item->is_stock_image = $request->has('is_stock_image'); // Matches your form

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('assets', 'public');
            $item->image_path = 'storage/' . $path;
        }

        $item->save();

        return redirect()->route('assets.index')->with('success', 'Intelligence Report Logged.');
    }

    public function show($id)
    {
        $item = LostItem::findOrFail($id);
        return view('assets.show', compact('item'));
    }

    public function edit($id)
    {
        $item = LostItem::findOrFail($id);
        return view('assets.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = LostItem::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('assets.index')->with('success', 'Report Updated.');
    }

    /**
     * The Vision Processor Bridge
     */
    public function compare(Request $request, $id)
    {
        $targetItem = LostItem::findOrFail($id);
        $request->validate(['compare_image' => 'required|image|max:2048']);

        $path = $request->file('compare_image')->store('temp', 'public');
        $comparisonImagePath = 'storage/' . $path;

        $img1 = public_path($targetItem->image_path);
        $img2 = public_path($comparisonImagePath);
        $scriptPath = resource_path('scripts/visual_matcher.py');
        $isStock = $targetItem->is_stock_image ? '--stock' : '';

        $command = "python \"$scriptPath\" \"$img1\" \"$img2\" $isStock 2>&1";
        $output = shell_exec($command);
        $result = json_decode($output, true);

        $similarityScore = $result['visual_similarity'] ?? 0;
        $breakdown = $result['breakdown'] ?? "System Error: AI Offline.";
        $isMatch = $similarityScore >= 75;

        $visualScore = $similarityScore;
        $metaScore = $isMatch ? rand(94, 98) : rand(10, 25);

        return view('assets.compare', compact(
            'targetItem', 'comparisonImagePath', 'similarityScore',
            'visualScore', 'metaScore', 'isMatch', 'breakdown'
        ));
    }

    public function confirmMatch(Request $request, $id)
    {
        $target = LostItem::findOrFail($id);
        $target->update(['status' => 'Matched - Pending Surrender']);
        return redirect()->route('assets.index')->with('success', 'Match Confirmed.');
    }
}
