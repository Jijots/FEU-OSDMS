<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('assets.index') }}" class="text-gray-400 hover:text-feu-green transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <span>AI Visual Analysis Report</span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12">
        @php
            $percentage = ($match->visual_similarity ?? 0) * 100;
            $isMatch = $percentage >= 50;
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border {{ $isMatch ? 'border-feu-green' : 'border-red-200' }} p-8 mb-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-8">
                <div class="relative">
                    <svg class="w-24 h-24 transform -rotate-90">
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-100" />
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent"
                            stroke-dasharray="251.2"
                            stroke-dashoffset="{{ 251.2 - (251.2 * $percentage / 100) }}"
                            class="{{ $isMatch ? 'text-feu-green' : 'text-red-500' }} transition-all duration-1000" />
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-2xl font-black text-gray-900">{{ number_format($percentage, 0) }}%</span>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Match Confidence</h2>
                    <p class="text-gray-500 font-medium mt-1">Verification Status: <span class="{{ $isMatch ? 'text-feu-green' : 'text-red-600' }} font-bold">{{ $isMatch ? 'Verified Correlation' : 'Inconclusive' }}</span></p>
                </div>
            </div>
            <div class="flex gap-4">
                <button class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">Flag for Review</button>
                <button class="px-8 py-3 bg-feu-green hover:bg-feu-green-dark text-white font-bold rounded-xl transition shadow-md">Confirm Match</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-700 uppercase tracking-widest text-xs">Original Report Image</h3>
                </div>
                <div class="p-6">
                    <div class="bg-slate-50 rounded-xl border border-dashed border-gray-300 flex items-center justify-center overflow-hidden h-96">
                        <img src="{{ asset($item->image_path) }}" class="max-h-full max-w-full object-contain" alt="Lost Item">
                    </div>
                    <div class="mt-6">
                        <span class="text-xs font-bold text-feu-green uppercase tracking-tighter bg-green-50 px-2 py-1 rounded">ID: #{{ $item->id }}</span>
                        <h4 class="text-xl font-black text-gray-900 mt-2">{{ $item->item_category }}</h4>
                        <p class="text-gray-600 mt-1">{{ $item->description }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-700 uppercase tracking-widest text-xs">Guard Scan Result</h3>
                </div>
                <div class="p-6">
                    <div class="bg-slate-50 rounded-xl border border-dashed border-gray-300 flex items-center justify-center overflow-hidden h-96 relative">
                        <img src="{{ asset('samples/found_hirono.jpg') }}" class="max-h-full max-w-full object-contain" alt="Scanned Item">

                        <div class="absolute inset-x-0 top-0 h-1 bg-feu-green/50 shadow-[0_0_15px_rgba(0,99,65,0.5)] animate-bounce mt-10"></div>
                    </div>
                    <div class="mt-6 bg-gray-900 rounded-xl p-4 border border-gray-800 shadow-inner">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 font-mono">Vision Processor v2.0</p>
                        <div class="font-mono text-green-400 text-sm">
                            <span class="text-green-600">$</span> {{ $match->breakdown ?? 'Analyzing pixels...' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
