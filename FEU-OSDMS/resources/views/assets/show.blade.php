<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">🚀 AI Visual Match Result</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-6">

            <!-- Confidence Score Banner -->
            @php
                $percentage = ($match->visual_similarity ?? 0) * 100;
                $matchStatus = $percentage > 80 ? 'green' : ($percentage > 50 ? 'yellow' : 'red');
            @endphp

            <div class="text-center">
                <div class="inline-block px-8 py-4 rounded-xl border-2 shadow-sm
                    {{ $matchStatus === 'green' ? 'border-green-500 bg-green-50' : ($matchStatus === 'yellow' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') }}">
                    <span class="block text-xs font-bold uppercase tracking-widest {{ $matchStatus === 'green' ? 'text-green-600' : ($matchStatus === 'yellow' ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $matchStatus === 'green' ? '✓ STRONG MATCH' : ($matchStatus === 'yellow' ? '⚠ MODERATE MATCH' : '✗ WEAK MATCH') }}
                    </span>
                    <span class="block text-5xl font-black {{ $matchStatus === 'green' ? 'text-green-700' : ($matchStatus === 'yellow' ? 'text-yellow-700' : 'text-red-700') }} mt-2">
                        {{ number_format($percentage, 1) }}%
                    </span>
                    <p class="text-xs {{ $matchStatus === 'green' ? 'text-green-600' : ($matchStatus === 'yellow' ? 'text-yellow-600' : 'text-red-600') }} mt-2">Confidence Score</p>
                </div>
            </div>

            <!-- Image Comparison -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Lost Item -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-600">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-2">📍</span>
                        <h3 class="font-bold text-lg text-gray-800">Reported Lost Item</h3>
                    </div>
                    <div class="h-64 bg-gray-100 rounded-lg mb-4 overflow-hidden flex items-center justify-center">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="object-cover h-full w-full" alt="Lost item">
                        @else
                            <span class="text-6xl">📦</span>
                        @endif
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="font-bold text-gray-800">{{ $item->item_category }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                        <p class="text-xs text-gray-500 mt-2">📍 {{ $item->location_found }}</p>
                    </div>
                </div>

                <!-- Found Item -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-600">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-2">🔍</span>
                        <h3 class="font-bold text-lg text-gray-800">Scanned Item</h3>
                    </div>
                    <div class="h-64 bg-gray-100 rounded-lg mb-4 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('samples/found_hirono.jpg') }}" class="object-cover h-full w-full" alt="Found item">
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="font-bold text-gray-800">Visual Analysis Result</p>
                        <p class="text-sm text-gray-600 mt-1">Processed through AI Computer Vision</p>
                        <p class="text-xs text-gray-500 mt-2">⚙️ {{ $match->breakdown ?? 'Shape & Color Analysis' }}</p>
                    </div>
                </div>
            </div>

            <!-- Match Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Feature Breakdown -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">📊 Feature Breakdown</h3>
                    <div class="space-y-3">
                        @if($match->breakdown)
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Analysis Details</p>
                                <p class="text-sm text-gray-800">{{ $match->breakdown }}</p>
                            </div>
                        @endif

                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-xs text-blue-600 font-semibold uppercase mb-1">Color Matching</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $percentage * 0.8 }}%"></div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-3 rounded-lg">
                            <p class="text-xs text-green-600 font-semibold uppercase mb-1">Shape/Feature Detection</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full transition-all" style="width: {{ $percentage * 0.9 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Match Status -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">✓ Match Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-{{ $matchStatus }}-50 rounded-lg border border-{{ $matchStatus }}-200">
                            <span class="font-semibold text-gray-800">Overall Match Quality</span>
                            <span class="px-3 py-1 bg-{{ $matchStatus }}-600 text-white rounded-full text-xs font-bold">
                                {{ $matchStatus === 'green' ? 'EXCELLENT' : ($matchStatus === 'yellow' ? 'GOOD' : 'LOW') }}
                            </span>
                        </div>

                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600 uppercase font-semibold mb-2">Recommendation</p>
                            @if($percentage > 80)
                                <p class="text-sm text-green-700 font-semibold">✓ This is likely a match. Proceed with verification.</p>
                            @elseif($percentage > 50)
                                <p class="text-sm text-yellow-700 font-semibold">⚠ Partial match detected. Manual review recommended.</p>
                            @else
                                <p class="text-sm text-red-700 font-semibold">✗ Low confidence. Try matching with different items.</p>
                            @endif
                        </div>

                        @if($match->error)
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-xs text-red-600 uppercase font-semibold">Error</p>
                            <p class="text-sm text-red-700">{{ $match->error }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4">
                <a href="{{ route('assets.index') }}" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition">
                    ← Back to Gallery
                </a>
                <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition">
                    ✓ Confirm Match
                </button>
            </div>

        </div>
    </div>
</x-app-layout>
