<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-14 px-4 sm:px-0 gap-8">
                <div class="space-y-1">
                    <h1 class="text-7xl font-black text-slate-900 tracking-tighter leading-none">IntelliThings Hub</h1>
                    <p class="text-xl text-slate-400 font-medium tracking-tight">Systematic asset cross-referencing and visual verification.</p>
                </div>
                <div class="shrink-0 flex items-center gap-4">
                    <a href="{{ route('assets.lost-ids') }}" class="px-8 py-4 bg-[#004d32] text-[#FECB02] rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:brightness-110 transition-all no-underline flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        ID RECOVERY VAULT
                    </a>
                    <a href="{{ route('assets.create') }}" class="btn-primary inline-flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        REPORT NEW ASSET
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[3.5rem] shadow-[0_45px_90px_-20px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[12px] font-black text-slate-600 uppercase tracking-[0.2em]">
                                <th class="px-10 py-8 w-24 text-center">Entry</th>
                                <th class="px-6 py-8 w-44 text-center">Preview</th>
                                <th class="px-6 py-8">Asset Details</th>
                                <th class="px-6 py-8 text-center w-64">Current Status</th>
                                <th class="px-10 py-8 text-right">Operation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($assets as $item)
                                <tr class="group hover:bg-slate-50/30 transition-all duration-500">
                                    <td class="px-10 py-12 text-center">
                                        <span class="text-sm font-black text-slate-200 group-hover:text-[#004d32] transition-colors">#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-6 py-12 text-center flex justify-center">
                                        <div class="relative w-28 h-28 rounded-[2.5rem] border-[7px] border-white shadow-2xl overflow-hidden bg-slate-50 transition-transform group-hover:scale-105">
                                            <img src="{{ $item->image_url }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                        </div>
                                    </td>
                                    <td class="px-6 py-12">
                                        <div class="flex flex-col">
                                            <span class="text-3xl font-black text-slate-900 tracking-tighter leading-none">{{ $item->item_category }}</span>
                                            <div class="flex items-center gap-3 mt-4">
                                                <span class="px-3.5 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] {{ $item->report_type === 'Lost' ? 'bg-[#ef4444] text-white' : 'bg-[#2563eb] text-white' }} shadow-lg shadow-black/5">
                                                    {{ $item->report_type }}
                                                </span>
                                                <span class="text-[10px] font-bold text-slate-200 uppercase tracking-widest">LOG: {{ $item->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-12 text-center">
                                        @php
                                            $status = $item->status;
                                            $style = 'background: #f8fafc; color: #94a3b8; border: 1.5px solid #f1f5f9;';
                                            if ($status === 'Claimed') {
                                                $style = 'background: #f0fdf4; color: #166534; border: 1.5px solid #dcfce7;';
                                            } elseif ($status === 'Pending Review') {
                                                $style = 'background: #fffaf0; color: #9a3412; border: 1.5px solid #ffedd5;';
                                            } elseif ($status === 'Matched - Pending Surrender') {
                                                $style = 'background: #f0f9ff; color: #075985; border: 1.5px solid #e0f2fe;';
                                            } elseif ($status === 'Lost') {
                                                $style = 'background: #fef2f2; color: #b91c1c; border: 1.5px solid #fee2e2;';
                                            }
                                        @endphp
                                        <span style="{{ $style }}" class="badge">{{ $status }}</span>
                                    </td>
                                    <td class="px-10 py-12">
                                        <div class="flex items-center justify-end gap-6">
                                            <a href="{{ route('assets.edit', $item->id) }}" class="text-slate-200 hover:text-slate-900 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('assets.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-slate-200 hover:text-red-500 transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <a href="{{ route('assets.show', $item->id) }}" style="background-color: #0f172a; color: white;" class="inline-flex items-center justify-center px-8 py-3.5 text-[10px] font-black rounded-2xl shadow-lg hover:bg-[#004d32] transition-all no-underline tracking-[0.15em]">
                                                SCAN & MATCH
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-40 text-center text-slate-200 font-black uppercase tracking-[0.4em] text-sm">
                                        Terminal Idle — No Records
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
