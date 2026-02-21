<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 py-10">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Asset Management</h1>
                <p class="text-base text-slate-500 font-medium mt-1">Manage, search, and verify all reported items.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('assets.create', ['type' => 'Missing']) }}" class="px-6 py-3 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm text-sm">
                    Log Missing Item
                </a>
                <a href="{{ route('assets.create', ['type' => 'Found']) }}" class="px-6 py-3 bg-[#004d32] text-white font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm text-sm">
                    Log Found Item
                </a>
            </div>
        </div>

        <div class="bg-white p-4 border-2 border-slate-200 rounded-2xl flex flex-col md:flex-row justify-between gap-4 mb-6 shadow-sm">
            <div class="flex gap-2">
                <a href="{{ route('assets.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('type') !== 'Missing' ? 'bg-[#FECB02] text-[#004d32] border-2 border-[#FECB02]' : 'text-slate-500 hover:bg-slate-50 border-2 border-transparent' }}">Found Items</a>
                <a href="{{ route('assets.index', ['type' => 'Missing']) }}" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ request('type') === 'Missing' ? 'bg-[#FECB02] text-[#004d32] border-2 border-[#FECB02]' : 'text-slate-500 hover:bg-slate-50 border-2 border-transparent' }}">Missing Items</a>
            </div>

            <form method="GET" action="{{ route('assets.index') }}" class="relative w-full md:w-96">
                <input type="hidden" name="type" value="{{ request('type', 'Found') }}">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tracking number or category..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:border-[#004d32] focus:ring-0 text-sm font-semibold transition-colors placeholder:font-medium">
            </form>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Tracking No.</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Category</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Details</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Status</th>
                            <th class="px-8 py-5 text-right text-sm font-bold text-slate-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse ($items as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-800 tracking-wider">#{{ $item->tracking_number }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold uppercase bg-slate-100 text-slate-600 border border-slate-200">{{ $item->item_category }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800">{{ $item->location_found ?? $item->location_lost }}</p>
                                    <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('M d, Y') : \Carbon\Carbon::parse($item->date_lost)->format('M d, Y') }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    @if($item->status == 'Active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase bg-green-100 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold uppercase bg-slate-100 text-slate-500 border border-slate-200">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <form method="POST" action="{{ route('assets.destroy', $item->id) }}" onsubmit="return confirm('Delete this record?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('assets.show', $item->id) }}" class="px-6 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-[#004d32] transition-colors shadow-sm">
                                            Verify Record
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-32 text-center text-slate-400 font-bold text-base">
                                    No records found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
