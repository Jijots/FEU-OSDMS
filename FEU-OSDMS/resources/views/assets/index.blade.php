<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">🔍 IntelliThings - Lost & Found</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <!-- Header Section -->
            <div class="mb-6 flex items-center justify-between">
                <p class="text-gray-600">Manage and match lost items using AI visual recognition</p>
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                    + Report Lost Item
                </button>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($items as $item)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                    <!-- Image Container -->
                    <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden relative group">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->item_category }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl">📦</span>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white {{ $item->is_claimed ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ $item->is_claimed ? '✓ Claimed' : '✗ Lost' }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $item->item_category }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $item->description }}</p>

                        <!-- Item Details -->
                        <div class="text-xs text-gray-500 space-y-1 mb-4">
                            <p>📍 Found at: <span class="font-semibold text-gray-700">{{ $item->location_found }}</span></p>
                            <p>👤 Found by: <span class="font-semibold text-gray-700">{{ $item->founder->name ?? 'N/A' }}</span></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('assets.compare', $item->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-xs uppercase transition text-center">
                                🚀 Run AI Match
                            </a>
                            <button class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 rounded-lg text-xs uppercase transition">
                                ℹ View Details
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-4xl mb-4">📭</p>
                    <p class="text-xl font-semibold text-gray-700 mb-2">No Lost Items Yet</p>
                    <p class="text-gray-500">There are currently no lost items in the system. Items will appear here once reported.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
