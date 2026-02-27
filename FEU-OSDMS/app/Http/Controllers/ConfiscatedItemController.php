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

   // 3. SECURELY STORE THE RECORD (Now with Photo Support!)
    public function store(Request $request)
    {
        $request->validate([
            // THE FIX: Removed 'exists:users,id_number' so officers can log ANY ID or name.
            'student_id' => 'nullable|string|max:255',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'storage_location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // Max 4MB Image
        ]);

        // Handle the Photo Upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Stores it in storage/app/public/evidence_photos
            $photoPath = $request->file('photo')->store('evidence_photos', 'public');
        }

        ConfiscatedItem::create([
            'student_id' => $request->student_id,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'photo_path' => $photoPath, // Save the path to the DB
            'confiscated_by' => Auth::user()->name,
            'confiscated_date' => now(),
            'storage_location' => $request->storage_location,
            'status' => 'Safekeeping',
        ]);

        return redirect()->route('confiscated-items.index')
            ->with('success', 'Contraband successfully secured and photographic evidence attached.');
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
