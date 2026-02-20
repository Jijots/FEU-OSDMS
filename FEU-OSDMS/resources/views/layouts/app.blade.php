<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FEU-OSDMS Command Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full scale-content" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">

        <nav x-show="sidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="sidebar-fixed w-72">

            <div class="space-y-4 pt-40 px-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-8 py-5 rounded-2xl transition-all no-underline group {{ request()->routeIs('dashboard') ? 'bg-[#FECB02] shadow-xl text-[#004d32]' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-[11px] font-black uppercase tracking-widest">Dashboard</span>
                </a>
                <a href="{{ route('assets.index') }}" class="flex items-center gap-4 px-8 py-5 rounded-2xl transition-all no-underline group {{ request()->routeIs('assets.*') ? 'bg-[#FECB02] shadow-xl text-[#004d32]' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-[11px] font-black uppercase tracking-widest">IntelliThings</span>
                </a>
            </div>

            <div class="p-10 border-t border-white/5 bg-black/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-4 text-[10px] font-black text-white/20 hover:text-red-500 uppercase tracking-widest transition-all">
                        Terminate Session
                    </button>
                </form>
            </div>
        </nav>

        <main class="flex-1 transition-all duration-300 h-full overflow-y-auto"
              :class="sidebarOpen ? 'ml-72' : 'ml-0'">
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
