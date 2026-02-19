<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;

class AssetMatchingController extends Controller
{
    public function index() {
        $items = LostItem::latest()->get();
        return view('assets.index', compact('items'));
    }

    public function create() {
        return view('assets.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'item_category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lost_items', 'public');
            LostItem::create([
                'item_category' => $validated['item_category'],
                'description' => $validated['description'],
                'image_path' => 'storage/' . $path,
            ]);
            return redirect()->route('assets.index')->with('success', 'Report Saved.');
        }
        return back();
    }

    public function edit($id) {
        $item = LostItem::findOrFail($id);
        return view('assets.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        $item = LostItem::findOrFail($id);
        $validated = $request->validate([
            'item_category' => 'required|string',
            'description' => 'required|string',
        ]);
        $item->update($validated);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lost_items', 'public');
            $item->update(['image_path' => 'storage/' . $path]);
        }
        return redirect()->route('assets.index');
    }

    public function compare(Request $request, $id) {
        $lostItem = LostItem::findOrFail($id);
        $foundImagePath = public_path('samples/found_hirono.jpg');
        $lostImagePath = public_path($lostItem->image_path);

        $script = resource_path('scripts/visual_matcher.py');
        $command = "python " . escapeshellarg($script) . " " . escapeshellarg($lostImagePath) . " " . escapeshellarg($foundImagePath) . " 2>&1";
        $output = shell_exec($command);
        $decoded = json_decode($output, true);

        return view('assets.show', [
            'item' => $lostItem,
            'match' => (object)($decoded ?? ['visual_similarity' => 0, 'breakdown' => 'Analysis Failed'])
        ]);
    }
}
