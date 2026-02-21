<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FEU-OSDMS | Administrative Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Global Font Enforcement */
        body { font-family: 'Public Sans', sans-serif !important; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full antialiased bg-[#F8FAFB] text-slate-900" x-data="{ sidebarOpen: false }">

    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-80 bg-[#004d32] transform transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none border-r border-white/5">
        @include('layouts.navigation')
    </aside>

    <div class="flex-1 transition-all duration-300 ease-in-out min-h-screen flex flex-col"
         :class="sidebarOpen ? 'lg:pl-80' : 'pl-0'">

        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-5 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 rounded-xl transition-all group">
                    <svg class="w-6 h-6 text-[#004d32] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="hidden md:block">
                    <h2 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] leading-none mb-1">Administrative Console</h2>
                    <p class="text-sm font-black text-[#004d32] tracking-tighter uppercase">FEU Institute of Technology</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-0.5">Terminal Status</p>
                    <div class="flex items-center gap-2 justify-end">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <p class="text-xs font-black text-[#004d32] tracking-tighter uppercase">ADMIN-{{ auth()->id() }}</p>
                    </div>
                </div>
                <div class="w-10 h-10 bg-[#004d32] rounded-xl flex items-center justify-center text-[#FECB02] font-black text-sm shadow-inner">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="p-8 lg:p-12 w-full max-w-7xl mx-auto">
            {{ $slot }}
        </main>
    </div>

    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition.opacity
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"
         x-cloak></div>

    @stack('scripts')
</body>
</html>
