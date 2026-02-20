<div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-7 flex items-center justify-between">
    <div class="flex items-center gap-12">
        <button @click="sidebarOpen = !sidebarOpen" class="group p-3 hover:bg-slate-100 rounded-2xl transition-all">
            <svg class="w-8 h-8 text-[#004d32] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}" class="hover:opacity-70 transition-all active:scale-95 block">
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </a>
    </div>

    <div class="text-right">
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System Terminal</p>
        <div class="flex items-center gap-2 justify-end">
            <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
            <p class="text-xs font-black text-[#004d32] tracking-tighter uppercase">ADMIN-{{ auth()->id() }}</p>
        </div>
    </div>
</div>
