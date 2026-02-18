<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('IntelliThings: Lost Item Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($items as $item)
                    <div class="border rounded-xl p-4 hover:shadow-md transition relative">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-[10px] font-bold uppercase
                            {{ $item->is_claimed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->is_claimed ? 'Claimed' : 'Missing' }}
                        </span>

                        <div class="h-40 bg-gray-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="object-cover h-full w-full">
                            @else
                                <span class="text-4xl">🎒</span>
                            @endif
                        </div>

                        <h3 class="font-bold text-gray-800">{{ $item->item_category }}</h3>
                        <p class="text-sm text-gray-500 mb-4 truncate">{{ $item->description }}</p>

                        <a href="{{ route('assets.compare', $item->id) }}"
                           class="block w-full text-center bg-blue-600 text-white font-bold py-2 rounded-lg text-xs uppercase hover:bg-blue-700 transition">
                            Run AI Match
                        </a>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-12 text-gray-400">
                        <p class="text-xl">No lost items reported yet.</p>
                        <p class="text-sm">Run the seeder or add items manually in the database.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
