<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class AssetMatchingController extends Controller
{
    /**
     * Absolute path to the Python environment containing Gemini libraries.
     */
    protected $pythonPath = 'C:\\Users\\Joss\\AppData\\Local\\Microsoft\\WindowsApps\\PythonSoftwareFoundation.Python.3.11_qbz5n2kfra8p0\\python.exe';

    /**
     * Helper method to convert Cropper.js Base64 strings into physical JPEG files.
     */
    private function saveBase64Image($base64String, $folder = 'assets')
    {
        $image_parts = explode(";base64,", $base64String);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.jpg';
        $path = $folder . '/' . $fileName;
        Storage::disk('public')->put($path, $image_base64);
        return $path;
    }

    /**
     * THE UPGRADE: Added Search, Tab Filtering, and fixed the $items variable.
     */
    public function index(Request $request)
    {
        $query = LostItem::query();

        // 1. Tab Filter: Toggle between 'Found' and 'Missing' items (Defaults to Found)
        $type = $request->input('type', 'Found');
        $query->where('report_type', $type);

        // 2. Routing: Exclude ID cards from the general 'Found' list because they belong in the ID Vault
        if ($type === 'Found') {
            $query->where('item_category', '!=', 'ID / Identification');
        }

        // 3. Search Bar Logic: Search by Tracking Number, Category, or Location
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%{$search}%")
                    ->orWhere('item_category', 'LIKE', "%{$search}%")
                    ->orWhere('location_found', 'LIKE', "%{$search}%")
                    ->orWhere('location_lost', 'LIKE', "%{$search}%");
            });
        }

        // 4. Send the data to the view as '$items' to match our new Blade file
        $items = $query->latest()->get();

        return view('assets.index', compact('items'));
    }

    /**
     * Automated Recovery Vault Scan for the Sidebar/Dashboard listing.
     * UPGRADED: 100% PHP Local Hardware Bypass to protect Gemini API Quotas.
     */
    public function lostIds()
    {
        // 1. Grab the students from the local database
        $students = User::select('id', 'name', 'id_number')->get();

        // 2. Grab the pending IDs
        $ids = LostItem::where('item_category', 'ID / Identification')
            ->where('report_type', 'Found')
            ->where('status', '!=', 'Claimed')
            ->latest()
            ->get()
            ->map(function ($item) use ($students) {

                // 3. FAST HARDWARE BYPASS (No Python, No Google API Limits!)
                // Extracts the 9-digit ID number from the text description
                preg_match('/\d{9}/', $item->description, $matches);
                $extractedId = !empty($matches) ? $matches[0] : '';

                // 4. Instantly check if that ID exists in your local student list
                if ($extractedId) {
                    $matchedStudent = $students->firstWhere('id_number', $extractedId);

                    if ($matchedStudent) {
                        $item->suggested_owner = $matchedStudent;
                        $item->confidence = 1.0; // 100% Match
                    }
                }

                return $item;
            });

        return view('assets.lost-ids', compact('ids'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function createId()
    {
        return view('assets.create-id');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required',
            'item_category' => 'required',
            'item_name' => 'required|string|max:255', // NEW ITEM NAME FIELD
            'description' => 'required',
            'location_found' => 'required',
            'cropped_image' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);


        if (!$request->filled('cropped_image') && !$request->hasFile('image')) {
            return back()->withErrors(['image' => 'An image capture is required.']);
        }

        $validated['is_stock_image'] = $request->has('is_stock_image') ? 1 : 0;

        // Handle Base64 Crop OR Standard Image fallback
        if ($request->filled('cropped_image')) {
            $validated['image_path'] = $this->saveBase64Image($request->input('cropped_image'));
        } else {
            $validated['image_path'] = $request->file('image')->store('assets', 'public');
        }

        $validated['date_lost'] = now();
        $validated['status'] = 'Active';

        LostItem::create($validated);
        return redirect()->route('assets.index')->with('success', 'Asset logged successfully.');
    }

    public function storeId(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string',
            'student_id' => 'required|string',
            'program' => 'required|string',
            'location_found' => 'required|string',
            'cropped_image' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if (!$request->filled('cropped_image') && !$request->hasFile('image')) {
            return back()->withErrors(['image' => 'An ID image is required.']);
        }

        $imagePath = $request->filled('cropped_image')
            ? $this->saveBase64Image($request->input('cropped_image'))
            : $request->file('image')->store('assets', 'public');

        $structuredDescription = "NAME: {$request->student_name} | ID: {$request->student_id} | PROGRAM: {$request->program}";

        LostItem::create([
            'item_category' => 'ID / Identification',
            'description' => $structuredDescription,
            'location_found' => $request->location_found,
            'report_type' => 'Found',
            'image_path' => $imagePath,
            'status' => 'Active',
            'date_lost' => now(),
        ]);

        return redirect()->route('assets.lost-ids')->with('success', 'ID Intelligence Logged.');
    }

    public function show($id)
    {
        $asset = LostItem::findOrFail($id);
        if (str_contains($asset->item_category, 'ID')) {
            preg_match('/\d{9}/', $asset->description, $matches);
            $student = !empty($matches) ? User::where('id_number', $matches[0])->first() : null;
            return view('assets.show-id', compact('asset', 'student'));
        }
        return view('assets.show', ['item' => $asset]);
    }

    public function edit($id)
    {
        $item = LostItem::findOrFail($id);
        return view('assets.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = LostItem::findOrFail($id);
        $data = $request->all();
        $data['is_stock_image'] = $request->has('is_stock_image') ? 1 : 0;

        // Ensure cropped edits overwrite correctly
        if ($request->filled('cropped_image')) {
            if ($item->image_path) Storage::disk('public')->delete($item->image_path);
            $data['image_path'] = $this->saveBase64Image($request->input('cropped_image'));
        } elseif ($request->hasFile('image')) {
            if ($item->image_path) Storage::disk('public')->delete($item->image_path);
            $data['image_path'] = $request->file('image')->store('assets', 'public');
        }

        $item->update($data);
        return redirect()->route('assets.index')->with('success', 'Record updated.');
    }

    /**
     * Gemini-Powered Semantic & Visual Comparison
     */
    public function compare(Request $request, $id)
    {
        $targetItem = LostItem::findOrFail($id);

        if ($request->filled('cropped_image')) {
            $path = $this->saveBase64Image($request->input('cropped_image'), 'temp');
            $comparisonImagePath = 'storage/' . $path;
            $uploadedImagePath = storage_path('app/public/' . $path);
        } elseif ($request->hasFile('compare_image')) {
            $path = $request->file('compare_image')->store('temp', 'public');
            $comparisonImagePath = 'storage/' . $path;
            $uploadedImagePath = storage_path('app/public/' . $path);
        } else {
            return back()->withErrors(['error' => 'No capture provided.']);
        }

        // --- THE TRAFFIC COP ---
        if ($targetItem->item_category === 'ID / Identification') {
            // 1. THIS IS FOR IDs (Semantic Matcher)
            $students = User::select('id', 'name', 'id_number')->get();
            $processArgs = [
                $this->pythonPath,
                base_path('resources/scripts/semantic_matcher.py'),
                $request->input('manual_name', ''),
                $request->input('manual_id', ''),
                $request->input('manual_program', ''),
                $students->toJson(),
                $uploadedImagePath
            ];
        } else {
            // 2. THIS IS FOR ALL OTHER LOST ITEMS (Visual Matcher)
            $targetImagePath = storage_path('app/public/' . $targetItem->image_path);

            // Base arguments for Python
            $processArgs = [$this->pythonPath, base_path('resources/scripts/visual_matcher.py'), $targetImagePath, $uploadedImagePath];

            // THE FIX: If the admin checked "Is Stock Image" when logging the Lost Item, add the flag!
            if ($targetItem->is_stock_image) {
                $processArgs[] = '--stock';
            }
        }

        $env = [
            'SystemRoot' => 'C:\\Windows',
            'windir'     => 'C:\\Windows',
            'HOME'       => 'C:\\Users\\Joss',
            'USERPROFILE' => 'C:\\Users\\Joss',
            'GOOGLE_API_KEY' => env('GOOGLE_API_KEY'),
        ];

        $process = new Process($processArgs, null, $env);
        $process->run();

        if ($process->isSuccessful()) {
            $output = $process->getOutput();
            $jsonStart = strpos($output, '{');
            $jsonEnd = strrpos($output, '}') + 1;

            if ($jsonStart !== false) {
                $cleanJson = substr($output, $jsonStart, $jsonEnd - $jsonStart);
                $result = json_decode($cleanJson, true);

                $rawScore = $result['confidence_score'] ?? $result['similarity_score'] ?? 0;
                $similarityScore = ($rawScore > 0 && $rawScore <= 1) ? intval($rawScore * 100) : intval($rawScore);
                $visualScore = $similarityScore;

                if ($targetItem->item_category === 'ID / Identification' && !empty($result['matched_student_id'])) {
                    $student = User::find($result['matched_student_id']);
                    $breakdown = $result['breakdown'] ?? ("Gemini Verified: " . ($student->name ?? 'Unknown'));

                    // --- CACHING LOGIC ---
                    if ($student && $similarityScore >= 75) {
                        if (!str_contains($targetItem->description, $student->id_number)) {
                            $targetItem->update([
                                'description' => $targetItem->description . ' | AI Verified ID: ' . $student->id_number
                            ]);
                        }
                    }
                } else {
                    $breakdown = $result['breakdown'] ?? $result['reason'] ?? 'Visual scan complete.';
                }
            } else {
                $similarityScore = 0;
                $visualScore = 0;
                $breakdown = "ERROR: No valid JSON output from Vision Processor.";
            }
        } else {
            $similarityScore = 0;
            $visualScore = 0;
            $breakdown = "> ERROR: VISION PROCESSOR FAILURE. " . $process->getErrorOutput();
        }

        $isMatch = $similarityScore >= 75;

        return view('assets.compare', compact('targetItem', 'comparisonImagePath', 'similarityScore', 'isMatch', 'visualScore', 'breakdown'));
    }

    public function confirmMatch($id)
    {
        LostItem::findOrFail($id)->update(['status' => 'Claimed']);
        return redirect()->route('assets.index')->with('success', 'Asset integrity confirmed.');
    }

    public function destroy($id)
    {
        $item = LostItem::findOrFail($id);
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }
        $item->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted.');
    }
}
