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

    public function index()
    {
        $assets = LostItem::oldest()->get();
        return view('assets.index', compact('assets'));
    }

    /**
     * Automated Recovery Vault Scan for the Sidebar/Dashboard listing.
     */
    public function lostIds()
    {
        $students = User::select('id', 'name', 'id_number')->get();

        // System environment to prevent Winsock/Runtime errors.
        $env = [
            'SystemRoot' => 'C:\\Windows',
            'windir'     => 'C:\\Windows',
            'HOME'       => 'C:\\Users\\Joss',
            'USERPROFILE' => 'C:\\Users\\Joss',
            'GOOGLE_API_KEY' => env('GOOGLE_API_KEY'),
        ];

        $ids = LostItem::where('item_category', 'ID / Identification')
            ->where('report_type', 'Found')
            ->where('status', '!=', 'Claimed')
            ->latest()
            ->get()
            ->map(function ($item) use ($students, $env) {
                $process = new Process([
                    $this->pythonPath,
                    base_path('resources/scripts/semantic_matcher.py'),
                    $item->description, '', '', $students->toJson()
                ], null, $env);

                $process->run();

                if ($process->isSuccessful()) {
                    $result = json_decode($process->getOutput(), true);
                    if ($result && !empty($result['matched_student_id'])) {
                        $item->suggested_owner = User::find($result['matched_student_id']);
                        $item->confidence = ($result['confidence_score'] ?? 0) / 100;
                    }
                }
                return $item;
            });

        return view('assets.lost-ids', compact('ids'));
    }

    public function create() { return view('assets.create'); }

    public function createId() { return view('assets.create-id'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required',
            'item_category' => 'required',
            'description' => 'required',
            'location_found' => 'required',
            'image' => 'required|image|max:2048'
        ]);

        $validated['is_stock_image'] = $request->has('is_stock_image') ? 1 : 0;
        $validated['image_path'] = $request->file('image')->store('assets', 'public');
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
            'image' => 'required|image|max:2048'
        ]);

        $structuredDescription = "NAME: {$request->student_name} | ID: {$request->student_id} | PROGRAM: {$request->program}";

        LostItem::create([
            'item_category' => 'ID / Identification',
            'description' => $structuredDescription,
            'location_found' => $request->location_found,
            'report_type' => 'Found',
            'image_path' => $request->file('image')->store('assets', 'public'),
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

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $request->file('image')->store('assets', 'public');
        }

        $item->update($data);
        return redirect()->route('assets.index')->with('success', 'Record updated.');
    }

    /**
     * Gemini-Powered Semantic Comparison for the Comparison Analysis View.
     */
    public function compare(Request $request, $id)
    {
        $targetItem = LostItem::findOrFail($id);

        if ($request->hasFile('compare_image')) {
            $path = $request->file('compare_image')->store('temp', 'public');
            $comparisonImagePath = 'storage/' . $path;

            if ($targetItem->item_category === 'ID / Identification') {
                $students = User::select('id', 'name', 'id_number')->get();
                $processArgs = [
                    $this->pythonPath,
                    base_path('resources/scripts/semantic_matcher.py'),
                    $request->input('manual_name', ''),
                    $request->input('manual_id', ''),
                    $request->input('manual_program', ''),
                    $students->toJson()
                ];
            } else {
                $targetImagePath = storage_path('app/public/' . $targetItem->image_path);
                $uploadedImagePath = storage_path('app/public/' . $path);
                $processArgs = [$this->pythonPath, base_path('resources/scripts/visual_matcher.py'), $targetImagePath, $uploadedImagePath];
            }

            // Sync Windows environment to prevent the RuntimeError and Winsock errors.
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
                $result = json_decode($process->getOutput(), true);

                // FIXED: Mapping integer scores to display variables correctly
                $similarityScore = $result['confidence_score'] ?? 0;
                $visualScore = $similarityScore;

                if ($targetItem->item_category === 'ID / Identification' && !empty($result['matched_student_id'])) {
                    $student = User::find($result['matched_student_id']);
                    $breakdown = $result['breakdown'] ?? ("Gemini Verified: " . ($student->name ?? 'Unknown'));
                } else {
                    $breakdown = $result['breakdown'] ?? 'Scan complete.';
                }
            } else {
                $similarityScore = 0;
                $visualScore = 0;
                $breakdown = "> ERROR: VISION PROCESSOR FAILURE. " . $process->getErrorOutput();
            }

            // Evaluation threshold
            $isMatch = $similarityScore >= 75;

            return view('assets.compare', compact('targetItem', 'comparisonImagePath', 'similarityScore', 'isMatch', 'visualScore', 'breakdown'));
        }

        return back()->withErrors(['error' => 'No capture provided.']);
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
