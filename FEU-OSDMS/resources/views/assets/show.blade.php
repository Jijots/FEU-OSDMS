<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('assets.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-widest flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Logs
                    </a>
                    <h2 class="font-black text-3xl text-gray-900 tracking-tight">AI Visual Match Result</h2>
                </div>
            </div>

            @php
                $percentage = ($match->visual_similarity ?? 0) * 100;
                $isMatch = $percentage >= 50;
            @endphp

            <div class="bg-white rounded-xl shadow-sm border {{ $isMatch ? 'border-feu-green' : 'border-red-200' }} p-6 mb-8 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-xl {{ $isMatch ? 'bg-feu-green/10 text-feu-green' : 'bg-red-50 text-red-600' }} flex items-center justify-center">
                        <span class="text-3xl font-black">{{ number_format($percentage, 0) }}<span class="text-xl">%</span></span>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-gray-900">Confidence Score</h3>
                        <p class="text-gray-500 mt-1">{{ $isMatch ? 'High visual correlation detected. Verification recommended.' : 'Low correlation. Items do not appear to match.' }}</p>
                    </div>
                </div>
                <div>
                    @if($isMatch)
                        <span class="px-4 py-2 bg-feu-green text-white font-bold rounded-lg text-sm">Strong Match</span>
                    @else
                        <span class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg text-sm">Weak Match</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Reported Lost Item</h3>
                        <span class="text-xs font-bold bg-white px-2 py-1 rounded text-gray-500 border border-gray-200">Database Record</span>
                    </div>
                    <div class="p-6">
                        <div class="aspect-square bg-gray-50 rounded-lg border border-gray-200 mb-6 flex justify-center items-center overflow-hidden">
                            <img src="{{ asset($item->image_path) }}" class="object-cover w-full h-full" alt="Lost item">
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Category</p>
                        <p class="font-black text-xl text-gray-900 mb-2">{{ $item->item_category }}</p>
                        <p class="text-gray-600">{{ $item->description }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                    <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Guard Station Scan</h3>
                        <span class="text-xs font-bold bg-white px-2 py-1 rounded text-blue-500 border border-blue-200">Live Camera</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="aspect-square bg-gray-50 rounded-lg border {{ $isMatch ? 'border-feu-green' : 'border-red-400' }} border-2 mb-6 flex justify-center items-center overflow-hidden relative">
                            <img src="{{ asset('samples/found_hirono.jpg') }}" class="object-cover w-full h-full" alt="Found item">
                            <div class="absolute inset-0 bg-feu-green/5 pointer-events-none border border-feu-green/20 m-4 rounded"></div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mt-auto">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">OpenCV Feature Breakdown</p>
                            <p class="font-mono text-sm text-gray-900">{{ $match->breakdown ?? 'Awaiting Data...' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">Reject Match</button>
                <button class="px-6 py-3 bg-feu-green hover:bg-feu-green-dark text-white font-bold rounded-lg transition shadow-md">Confirm Identity & Resolve</button>
            </div>

        </div>
    </div>
</x-app-layout>
