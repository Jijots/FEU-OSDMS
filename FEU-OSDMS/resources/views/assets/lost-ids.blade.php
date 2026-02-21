<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 py-10">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">ID Recovery Vault</h1>
                <p class="text-base text-slate-500 font-medium mt-1">Pending student identification cards requiring visual verification.</p>
            </div>
            <a href="{{ route('assets.create-id') }}" class="px-6 py-3 bg-[#004d32] text-white font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm text-sm">
                Log Found ID Card
            </a>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Tracking No.</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">ID Information</th>
                            <th class="px-8 py-5 text-center text-sm font-bold text-slate-500 uppercase tracking-wide">System Match Status</th>
                            <th class="px-8 py-5 text-right text-sm font-bold text-slate-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse ($ids as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-800">#{{ $item->tracking_number }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    @if(isset($item->suggested_owner))
                                        <p class="text-sm font-bold text-[#004d32]">{{ $item->suggested_owner->name }}</p>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $item->suggested_owner->id_number }}</p>
                                    @else
                                        <p class="text-sm font-medium text-slate-600 truncate max-w-xs">{{ $item->description }}</p>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if(isset($item->confidence))
                                        <span class="inline-flex px-4 py-1.5 rounded-lg text-xs font-bold uppercase bg-yellow-50 text-yellow-700 border border-yellow-200">
                                            Smart Match: {{ $item->confidence * 100 }}%
                                        </span>
                                    @else
                                        <span class="inline-flex px-4 py-1.5 rounded-lg text-xs font-bold uppercase bg-slate-100 text-slate-600 border border-slate-200">
                                            Awaiting Verification
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('assets.show', $item->id) }}" class="px-6 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-[#004d32] transition-colors shadow-sm inline-block">
                                        Scan & Verify
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-32 text-center text-slate-400 font-bold text-base">
                                    The ID Vault is currently empty. No pending IDs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
