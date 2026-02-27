<?php

namespace App\Http\Controllers;

use App\Models\ConfiscatedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfiscatedItemController extends Controller
{
    // 1. VIEW THE EVIDENCE LOCKER
    public function index(Request $request)
    {
        $query = ConfiscatedItem::with('student')->latest('confiscated_date');

        // Simple search by item name or student ID
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('item_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
        }

        $items = $query->paginate(10);
        return view('confiscated.index', compact('items'));
    }

    // 2. LOG A NEW CONFISCATED ITEM
    public function create()
    {
        return view('confiscated.create');
    }

    // 3. SECURELY STORE THE RECORD
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|exists:users,id_number',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'storage_location' => 'nullable|string|max:255',
        ]);

        ConfiscatedItem::create([
            'student_id' => $request->student_id,
            'item_name' => $request->item_name,
            'description' => $request->description,
            // Automatically log the Admin who is logged in! Zero tampering.
            'confiscated_by' => Auth::user()->name,
            'confiscated_date' => now(),
            'storage_location' => $request->storage_location,
            'status' => 'Safekeeping', // Default strict status
        ]);

        return redirect()->route('confiscated-items.index')
            ->with('success', 'Contraband successfully secured in the Evidence Locker.');
    }

    // 4. VIEW ITEM TO UPDATE CHAIN-OF-CUSTODY (Return or Dispose)
    public function edit($id)
    {
        $item = ConfiscatedItem::findOrFail($id);
        return view('confiscated.edit', compact('item'));
    }

    // 5. PROCESS THE DISPOSAL OR RETURN
    public function update(Request $request, $id)
    {
        $item = ConfiscatedItem::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Safekeeping,Returned,Disposed',
            'resolution_notes' => 'nullable|string',
        ]);

        $item->update([
            'status' => $request->status,
            'resolution_notes' => $request->resolution_notes,
        ]);

        return redirect()->route('confiscated-items.index')
            ->with('success', 'Chain of custody updated successfully.');
    }

    // 6. OVERRIDE DELETE (Admin Only)
    public function destroy($id)
    {
        $item = ConfiscatedItem::findOrFail($id);
        $item->delete();

        return redirect()->route('confiscated-items.index')
            ->with('success', 'Record permanently wiped from the ledger.');
    }
}
