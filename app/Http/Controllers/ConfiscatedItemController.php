<?php

namespace App\Http\Controllers;

use App\Models\ConfiscatedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Added to handle physical image deletion

class ConfiscatedItemController extends Controller
{
    // 1. VIEW THE ACTIVE EVIDENCE LOCKER
    public function index(Request $request)
    {
        // Eloquent automatically hides archived (soft-deleted) items
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

    // 2. VIEW THE ARCHIVES (New Method)
    public function archived(Request $request)
    {
        // 'onlyTrashed' retrieves ONLY the archived records
        $query = ConfiscatedItem::onlyTrashed()->with('student')->latest('deleted_at');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('item_name', 'like', "%{$search}%")
                ->orWhere('student_id', 'like', "%{$search}%");
        }

        $items = $query->paginate(10);
        return view('confiscated.archives', compact('items'));
    }

    // 3. LOG A NEW CONFISCATED ITEM
    public function create()
    {
        return view('confiscated.create');
    }

    // 4. SECURELY STORE THE RECORD
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|string|max:255',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'storage_location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // Handle the Photo Upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('evidence_photos', 'public');
        }

        ConfiscatedItem::create([
            'student_id' => $request->student_id,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'photo_path' => $photoPath,
            'confiscated_by' => Auth::user()->name,
            'confiscated_date' => now(),
            'storage_location' => $request->storage_location,
            'status' => 'Safekeeping',
        ]);

        return redirect()->route('confiscated-items.index')
            ->with('success', 'Contraband successfully secured and photographic evidence attached.');
    }

    // 5. VIEW ITEM TO UPDATE CHAIN-OF-CUSTODY
    public function edit($id)
    {
        $item = ConfiscatedItem::findOrFail($id);
        return view('confiscated.edit', compact('item'));
    }

    // 6. PROCESS THE DISPOSAL OR RETURN
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

    // 7. ARCHIVE RECORD (Soft Delete)
    public function destroy($id)
    {
        $item = ConfiscatedItem::findOrFail($id);

        // WE DO NOT DELETE THE PHOTO HERE!
        // We leave it intact in case we need to Restore the record later.
        $item->delete();

        return redirect()->route('confiscated-items.index')
            ->with('success', 'Record securely moved to the Archives.');
    }

    // 8. RESTORE RECORD (New Method)
    public function restore($id)
    {
        $item = ConfiscatedItem::withTrashed()->findOrFail($id);
        $item->restore();

        return redirect()->route('confiscated-items.archived')
            ->with('success', 'Record restored to the active Evidence Locker.');
    }

    // 9. PERMANENT DELETE (New Method)
    public function forceDelete($id)
    {
        $item = ConfiscatedItem::withTrashed()->findOrFail($id);

        // NOW we permanently wipe the physical photo from the server
        if ($item->photo_path) {
            Storage::disk('public')->delete($item->photo_path);
        }

        $item->forceDelete();

        return redirect()->route('confiscated-items.archived')
            ->with('success', 'Record and evidence permanently expunged from the system.');
    }
}
