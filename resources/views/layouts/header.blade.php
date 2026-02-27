<header class="sticky top-0 bg-white border-b-4 border-slate-200 z-30 px-8 py-6 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-6">
        <button @click="sidebarOpen = !sidebarOpen" class="group p-3 hover:bg-slate-100 rounded-xl transition-all border-2 border-slate-200 hover:border-slate-300">
            <svg class="w-8 h-8 text-slate-600 group-hover:text-[#004d32] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-5 hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU OSDMS Logo" class="h-12 w-auto">

            <div class="hidden md:block border-l-2 border-slate-300 pl-5">
                <h2 class="text-lg font-bold text-[#004d32] tracking-wide uppercase leading-tight">Far Eastern University</h2>
                <p class="text-sm font-bold text-slate-500 uppercase mt-1">Office of Student Discipline</p>
            </div>
        </a>
    </div>

    <div class="text-right flex items-center gap-4">
        <div class="hidden sm:block text-right">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-2">Admin Portal</p>
            <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-xl border-2 border-slate-300">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-sm"></div>
                <p class="text-base font-bold text-[#004d32] uppercase">Admin-{{ auth()->id() }}</p>
            </div>
        </div>
    </div>
</header>
