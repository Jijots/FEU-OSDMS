<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <a href="{{ route('assets.index') }}" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <a href="{{ route('assets.create-id') }}" class="px-8 py-3.5 bg-[#004d32] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#FECB02] hover:text-[#004d32] transition-all no-underline">
                LOG NEW ID
            </a>
        </div>
    </div>

    <div class="py-12 bg-[#F8FAFB]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-14">
                <h1 class="text-7xl font-black text-slate-900 tracking-tighter leading-none uppercase">ID Recovery Vault</h1>
                <p class="text-xl text-slate-400 font-medium mt-4">Semantic cross-referencing against the official student directory.</p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <tbody class="divide-y divide-slate-50">
                        @forelse($ids as $item)
                            <tr class="group hover:bg-slate-50/40 transition-all duration-300">
                                <td class="px-12 py-10 text-center w-32">
                                    <span class="text-sm font-black text-slate-200 group-hover:text-slate-400">#{{ str_pad($item->id, 2, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-8 py-10">
                                    <div class="flex items-center gap-8">
                                        <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden shrink-0 group-hover:scale-105 transition-transform">
                                            <img src="{{ asset($item->image_path) }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-900 text-2xl tracking-tight mb-1">{{ $item->report_type }} ID</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ \Illuminate\Support\Str::limit($item->description, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-10 text-center">
                                    @if(isset($item->confidence))
                                        <span class="inline-flex px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest bg-yellow-50 text-yellow-700">AI MATCH: {{ $item->confidence * 100 }}%</span>
                                    @else
                                        <span class="inline-flex px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500">PENDING SCAN</span>
                                    @endif
                                </td>
                                <td class="px-12 py-10 text-right">
                                    <a href="{{ route('assets.show', $item->id) }}" style="background-color: #0f172a; color: white;" class="inline-flex items-center justify-center px-8 py-3.5 text-[10px] font-black rounded-2xl shadow-lg hover:bg-[#004d32] transition-all no-underline tracking-[0.15em]">
                                        SCAN & MATCH
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-8 py-40 text-center text-slate-300 font-black uppercase tracking-[0.2em] text-xs">Vault Secure: Zero Pending IDs</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
