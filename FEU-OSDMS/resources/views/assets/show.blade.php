<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">IntelliMatch Analysis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-lg border-l-8 border-green-700">
                <div class="flex flex-row justify-around items-center mb-8">
                    <div class="text-center">
                        <p class="font-bold text-red-600 mb-2 underline">STUDENT REPORT</p>
                        <img src="{{ asset('storage/' . $item->image_path) }}" class="w-48 h-48 object-cover rounded shadow">
                    </div>

                    <div class="text-center">
                        <div class="text-5xl font-black {{ $match->visual_similarity > 0.6 ? 'text-green-600' : 'text-orange-500' }}">
                            {{ number_format($match->visual_similarity * 100, 0) }}%
                        </div>
                        <p class="text-xs font-bold uppercase text-gray-400">Similarity Score</p>
                    </div>

                    <div class="text-center">
                        <p class="font-bold text-green-600 mb-2 underline">GUARD CAPTURE</p>
                        <img src="{{ asset('storage/samples/found_sample.jpg') }}" class="w-48 h-48 object-cover rounded shadow">
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 p-4 rounded text-center">
                    <h4 class="font-bold text-gray-700">OpenCV Analysis</h4>
                    <p class="text-sm italic text-gray-600">{{ $match->breakdown }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>