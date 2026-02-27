<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 border-b-2 border-red-900 pb-5">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                    <svg class="w-8 h-8 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Confiscated Inventory
                </h1>
                <p class="text-sm text-slate-500 mt-1 font-bold uppercase tracking-widest">Confiscated Asset Chain-of-Custody</p>
            </div>

            <a href="{{ route('confiscated-items.create') }}" class="px-6 py-3 bg-red-800 text-white font-bold rounded-xl shadow-lg hover:bg-red-900 transition-all flex items-center gap-2 active:scale-95 border-2 border-transparent focus:ring-4 focus:ring-red-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Log Confiscated Item
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-600 text-green-800 rounded-r-lg font-bold flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 flex justify-between items-center">
            <form action="{{ route('confiscated-items.index') }}" method="GET" class="flex w-full max-w-md relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Student ID or Item Name..." class="w-full pl-10 border-slate-300 rounded-l-lg focus:ring-red-500 focus:border-red-500 font-medium text-sm">
                <button type="submit" class="bg-slate-800 text-white px-5 rounded-r-lg font-bold hover:bg-slate-700 transition-colors">Search</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 font-extrabold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="p-5 border-b border-slate-200">Date Logged</th>
                            <th class="p-5 border-b border-slate-200">Item / Contraband</th>
                            <th class="p-5 border-b border-slate-200">Taken From</th>
                            <th class="p-5 border-b border-slate-200">Storage Vault</th>
                            <th class="p-5 border-b border-slate-200">Status</th>
                            <th class="p-5 border-b border-slate-200 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-5 font-semibold text-slate-800">{{ \Carbon\Carbon::parse($item->confiscated_date)->format('M d, Y') }}</td>
                            <td class="p-5">
                                <p class="font-extrabold text-slate-900 text-base">{{ $item->item_name }}</p>
                                <p class="text-xs text-slate-500 truncate max-w-[200px] mt-0.5">{{ $item->description ?? 'No extra details provided.' }}</p>
                            </td>
                            <td class="p-5">
                                @if($item->student)
                                    <p class="font-bold text-slate-800">{{ $item->student->name }}</p>
                                    <p class="font-mono text-xs text-slate-500 mt-0.5 font-bold">{{ $item->student_id }}</p>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $item->student_id ?? 'Unknown' }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 font-mono text-xs font-bold text-slate-600">
                                {{ $item->storage_location ?? 'Pending Transfer' }}
                            </td>
                            <td class="p-5">
                                @if($item->status == 'Safekeeping')
                                    <span class="px-3 py-1.5 bg-amber-100 text-amber-800 border border-amber-200 rounded-lg text-xs font-extrabold uppercase tracking-wide">Safekeeping</span>
                                @elseif($item->status == 'Returned')
                                    <span class="px-3 py-1.5 bg-green-100 text-green-800 border border-green-200 rounded-lg text-xs font-extrabold uppercase tracking-wide">Returned</span>
                                @else
                                    <span class="px-3 py-1.5 bg-slate-100 text-slate-800 border border-slate-300 rounded-lg text-xs font-extrabold uppercase tracking-wide">Disposed</span>
                                @endif
                            </td>
                            <td class="p-5 text-right">
                                <a href="{{ route('confiscated-items.edit', $item->id) }}" class="inline-flex items-center gap-1 text-sm font-bold text-red-600 hover:text-red-900 transition-colors">
                                    Update Custody
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wide">Locker Empty</h3>
                                <p class="text-sm text-slate-500 mt-1">No confiscated contraband has been logged into the system yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($items->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
