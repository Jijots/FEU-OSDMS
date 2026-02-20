<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 bg-[#004d32] rounded-lg flex items-center justify-center shadow-lg shadow-green-900/10">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-[10px] font-black text-slate-500 tracking-[0.3em] uppercase">IntelliThings Hub</h2>
            </div>
            <span
                class="text-[9px] font-bold text-slate-400 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-slate-100 shadow-sm">Terminal:
                0922-FEU</span>
        </div>
    </x-slot>
    <div
        class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </div>

        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] leading-none mb-1">System
                    Terminal</p>
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
                    <p class="text-xl text-slate-400 font-medium tracking-tight">Systematic asset cross-referencing and
                        visual verification.</p>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('assets.create') }}"
                        style="background: linear-gradient(145deg, #004d32 0%, #003a26 100%); color: white; box-shadow: 0 10px 25px -8px rgba(0, 58, 38, 0.5);"
                        class="inline-flex items-center justify-center gap-4 px-10 py-5 font-black rounded-[1.5rem] hover:brightness-110 hover:-translate-y-0.5 transition-all no-underline tracking-tight text-sm uppercase group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        REPORT NEW ASSET
                    </a>
                </div>
            </div>

            <div
                class="bg-white rounded-[3.5rem] shadow-[0_45px_90px_-20px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50/50 border-b border-slate-100 text-[12px] font-black text-slate-600 uppercase tracking-[0.2em]">
                                <th class="px-10 py-8 w-24 text-center">Entry</th>
                                <th class="px-6 py-8 w-44 text-center">Preview</th>
                                <th class="px-6 py-8">Asset Details</th>
                                <th class="px-6 py-8 text-center w-64">Current Status</th>
                                <th class="px-10 py-8 text-right">Operation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($items as $item)
                                <tr class="group hover:bg-slate-50/30 transition-all duration-500">
                                    <td class="px-10 py-12 text-center">
                                        <span
                                            class="text-sm font-black text-slate-200 group-hover:text-[#004d32] transition-colors">#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    </td>

                                    <td class="px-6 py-12 text-center flex justify-center">
                                        <div
                                            class="relative w-28 h-28 rounded-[2.5rem] border-[7px] border-white shadow-2xl overflow-hidden bg-slate-50 transition-transform group-hover:scale-105">
                                            @if ($item->image_path)
                                                <img src="{{ asset($item->image_path) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-300">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-12">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-3xl font-black text-slate-900 tracking-tighter leading-none">{{ $item->item_category }}</span>
                                            <div class="flex items-center gap-3 mt-4">
                                                <span
                                                    class="px-3.5 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] {{ $item->report_type === 'Lost' ? 'bg-[#ef4444] text-white' : 'bg-[#2563eb] text-white' }} shadow-lg shadow-black/5">
                                                    {{ $item->report_type }}
                                                </span>
                                                <span
                                                    class="text-[10px] font-bold text-slate-200 uppercase tracking-widest">LOG:
                                                    {{ $item->id }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-12 text-center">
                                        @php
                                            $status = $item->status;
                                            $style =
                                                'background: #f8fafc; color: #94a3b8; border: 1.5px solid #f1f5f9;';
                                            if ($status === 'Claimed') {
                                                $style =
                                                    'background: #f0fdf4; color: #166534; border: 1.5px solid #dcfce7;';
                                            } elseif ($status === 'Pending Review') {
                                                $style =
                                                    'background: #fffaf0; color: #9a3412; border: 1.5px solid #ffedd5;';
                                            } elseif ($status === 'Matched - Pending Surrender') {
                                                $style =
                                                    'background: #f0f9ff; color: #075985; border: 1.5px solid #e0f2fe;';
                                            } elseif ($status === 'Lost') {
                                                $style =
                                                    'background: #fef2f2; color: #b91c1c; border: 1.5px solid #fee2e2;';
                                            }
                                        @endphp
                                        <span style="{{ $style }}"
                                            class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-[0.15em] whitespace-nowrap shadow-sm">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    <td class="px-10 py-12">
                                        <div class="flex items-center justify-end gap-6">
                                            <a href="{{ route('assets.edit', $item->id) }}"
                                                class="text-slate-200 hover:text-slate-900 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                                    </path>
                                                </svg>
                                            </a>

                                            <a href="{{ route('assets.show', $item->id) }}"
                                                style="background-color: #0f172a; color: white;"
                                                class="inline-flex items-center justify-center px-8 py-3.5 text-[10px] font-black rounded-2xl shadow-lg hover:bg-[#004d32] transition-all no-underline tracking-[0.15em]">
                                                SCAN & MATCH
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-8 py-40 text-center text-slate-200 font-black uppercase tracking-[0.4em] text-sm">
                                        Terminal Idle — No Records</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
