<nav class="bg-[#004d32] border-r border-white/5 h-full w-full flex flex-col relative">

    <div class="px-8 py-12 flex flex-col items-start gap-4 shrink-0">
        <button @click="sidebarOpen = false" class="absolute top-8 right-8 text-white/20 hover:text-[#FECB02] transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <a href="{{ route('dashboard') }}" class="block no-underline group">
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-9 w-auto transition-all group-hover:opacity-80">
            <div class="mt-6">
                <span class="block text-[#FECB02] text-[13px] font-black uppercase tracking-[0.2em] leading-tight opacity-95">
                    OSD Management System
                </span>
            </div>
        </a>
    </div>

    <div class="px-5 py-4 space-y-2 flex-1 overflow-y-auto">
        @php $activeClass = 'bg-[#FECB02] shadow-xl'; @endphp

        <a href="{{ route('dashboard') }}" class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('dashboard') ? $activeClass : 'hover:bg-white/5' }}">
            <div class="{{ request()->routeIs('dashboard') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">Dashboard</span>
        </a>

        <div class="space-y-1">
            <a href="{{ route('assets.index') }}" class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('assets.index') ? $activeClass : 'hover:bg-white/5' }}">
                <div class="{{ request()->routeIs('assets.index') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('assets.index') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">Asset Management</span>
            </a>

            <a href="{{ route('assets.lost-ids') }}" class="flex items-center gap-5 px-10 py-3 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('assets.lost-ids') ? 'text-[#FECB02]' : 'text-white/20 hover:text-white hover:bg-white/5' }}">
                <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('assets.lost-ids') ? 'bg-[#FECB02]' : 'bg-white/20' }}"></div>
                <span class="text-[9px] font-black uppercase tracking-widest">ID Recovery Vault</span>
            </a>
        </div>

        <a href="{{ route('students.index') }}" class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('students.*') ? $activeClass : 'hover:bg-white/5' }}">
            <div class="{{ request()->routeIs('students.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('students.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">Student Directory</span>
        </a>

        <a href="{{ route('gate.index') }}" class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('gate.*') ? $activeClass : 'hover:bg-white/5' }}">
            <div class="{{ request()->routeIs('gate.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('gate.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">Gate Entry</span>
        </a>

        <a href="{{ route('violations.report') }}" class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('violations.*') ? $activeClass : 'hover:bg-white/5' }}">
            <div class="{{ request()->routeIs('violations.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('violations.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">Violations</span>
        </a>
    </div>

    <div class="p-10 border-t border-white/5 bg-black/5 shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-4 border border-white/10 hover:bg-red-500/10 hover:text-red-500 hover:border-red-500/20 rounded-full text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] transition-all">
                Log Out
            </button>
        </form>
    </div>
</nav>
