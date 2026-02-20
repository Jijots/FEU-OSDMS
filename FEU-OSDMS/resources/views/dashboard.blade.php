<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
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

    <div class="py-12 px-12" style="zoom: 0.75;">
        <div class="max-w-7xl mx-auto">
            <div class="mb-14">
                <h1 class="text-8xl font-black text-slate-900 tracking-tighter leading-tight mb-4">Good Afternoon, OSD!</h1>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ $sy }} | {{ $semester }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="bg-[#5BC67F] p-10 rounded-[2.5rem] shadow-xl text-white">
                    <span class="text-[11px] font-black uppercase tracking-[0.2em] opacity-80">Total Incidents</span>
                    <div class="text-8xl font-black mt-2 tracking-tighter leading-none">{{ $lostCount + $foundCount }}</div>
                </div>
                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-slate-50 shadow-sm text-center">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Pending Reports</span>
                    <div class="text-8xl font-black text-[#5BC67F] mt-2 tracking-tighter">3</div>
                </div>
                <div class="bg-[#F59E0B] p-10 rounded-[2.5rem] shadow-xl text-white text-center">
                    <span class="text-[11px] font-black uppercase tracking-[0.2em] opacity-80">Active Violations</span>
                    <div class="text-8xl font-black mt-2 tracking-tighter">{{ $activeViolations }}</div>
                </div>
            </div>

            <div class="bg-white p-16 rounded-[3.5rem] border-2 border-slate-50 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[12px] font-black text-slate-300 uppercase tracking-[0.2em]">Verified Intelligence Logs</span>
                    <div class="text-9xl font-black text-slate-900 mt-2 tracking-tighter leading-none">{{ $foundCount + $lostCount }}</div>
                    <div class="flex gap-4 mt-8">
                        <span class="px-6 py-2.5 bg-green-50 text-[#004d32] rounded-xl text-[10px] font-black uppercase">{{ $foundCount }} Found Records</span>
                        <span class="px-6 py-2.5 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase">{{ $lostCount }} Lost Records</span>
                    </div>
                </div>
                <a href="{{ route('assets.index') }}" class="px-12 py-6 bg-[#004d32] text-white rounded-3xl font-black uppercase tracking-widest text-xs shadow-2xl hover:brightness-110 transition-all no-underline">
                    Open Complete Logs
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
