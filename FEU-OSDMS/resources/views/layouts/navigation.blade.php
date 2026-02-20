<nav x-data="{ open: false }" class="bg-[#004d32] border-r border-white/5 min-h-screen w-80 fixed left-0 top-0 shadow-2xl z-50">

    <div class="px-8 py-16 flex flex-col items-start gap-3">
        <a href="{{ route('dashboard') }}" class="block no-underline group">
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-7 w-auto transition-all group-hover:opacity-80">
            <span class="block text-[#FECB02] text-[8px] font-black uppercase tracking-[0.4em] mt-6 opacity-60">
                Intelligence Division Hub
            </span>
        </a>
    </div>

    <div class="px-5 py-4 space-y-2">
        @php $activeClass = 'bg-[#FECB02] shadow-xl'; @endphp

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('dashboard') ? $activeClass : 'hover:bg-white/5' }}">
            <div class="{{ request()->routeIs('dashboard') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                Dashboard
            </span>
        </a>

        <a href="{{ route('assets.index') }}"
           class="flex items-center gap-5 px-7 py-4 rounded-[2rem] transition-all no-underline group {{ request()->routeIs('assets.*') ? $activeClass : 'hover:bg-white/5' }}">
            <div class="{{ request()->routeIs('assets.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('assets.*') ? 'text-[#004d32]' : 'text-white/40 group-hover:text-white' }}">
                IntelliThings
            </span>
        </a>
    </div>

    <div class="absolute bottom-0 left-0 w-full p-10 border-t border-white/5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-4 border border-white/10 hover:bg-red-500/10 hover:text-red-500 hover:border-red-500/20 rounded-full text-[9px] font-black text-white/30 uppercase tracking-[0.4em] transition-all">
                Terminate Session
            </button>
        </form>
    </div>
</nav>
