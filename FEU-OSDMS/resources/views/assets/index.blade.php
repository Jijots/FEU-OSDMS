<x-app-layout>
    <x-slot name="header">IntelliThings Asset Database</x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Reported Lost Items</h2>
                <p class="text-sm text-gray-500 font-medium mt-1">Manage campus property and initiate AI matching protocols.</p>
            </div>
            <a href="{{ route('assets.create') }}" class="px-6 py-3 bg-feu-green hover:bg-feu-green-dark text-white font-bold rounded-xl shadow-lg flex items-center gap-2 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Report New Item
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-200 text-[10px] uppercase tracking-[0.2em] font-black text-gray-400">
                            <th class="px-8 py-5">Preview</th>
                            <th class="px-8 py-5">Item Name</th>
                            <th class="px-8 py-5">Description</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="w-20 h-20 rounded-2xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center">
                                    <img src="{{ asset($item->image_path) }}" alt="Item" class="object-cover w-full h-full">
                                </div>
                            </td>
                            <td class="px-8 py-5 font-bold text-gray-900 text-lg">{{ $item->item_category }}</td>
                            <td class="px-8 py-5 text-gray-500 text-sm max-w-sm leading-relaxed">{{ $item->description }}</td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('assets.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-feu-green transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <a href="{{ route('assets.compare', $item->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-feu-green hover:text-white hover:border-feu-green transition-all shadow-sm">
                                        Run AI Match
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-8 py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">No records found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
