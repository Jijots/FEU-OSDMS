<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('AI Visual Match Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 text-center">
                <div class="inline-block px-6 py-2 rounded-full border-2
                    {{ $match->match_score > 80 ? 'border-green-500 bg-green-50 text-green-700' : 'border-yellow-500 bg-yellow-50 text-yellow-700' }}">
                    <span class="block text-xs font-bold uppercase tracking-widest">Confidence Score</span>
                    <span class="block text-3xl font-black">{{ number_format($match->match_score, 1) }}%</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-red-500">
                    <h3 class="font-bold text-gray-400 text-xs uppercase mb-4">Reported Lost Item</h3>
                    <div class="h-64 bg-gray-100 rounded-lg mb-4 overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image_path) }}" class="object-cover h-full w-full">
                    </div>
                    <p class="font-bold text-lg">{{ $item->item_category }}</p>
                    <p class="text-gray-600">{{ $item->description }}</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-blue-500">
                    <h3 class="font-bold text-gray-400 text-xs uppercase mb-4">Found Item (Scanned)</h3>
                    <div class="h-64 bg-gray-100 rounded-lg mb-4 overflow-hidden">
                        <img src="{{ asset('storage/samples/found_sample.jpg') }}" class="object-cover h-full w-full">
                    </div>
                    <p class="font-bold text-lg">Visual Analysis</p>
                    <p class="text-gray-600 text-sm mt-2">
                        Features Detected: {{ implode(', ', $match->keypoints ?? ['Color', 'Shape', 'Texture']) }}
                    </p>
                </div>
            </div>

            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('assets.index') }}" class="text-gray-500 font-bold text-sm hover:underline">
                    ← Back to Gallery
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
