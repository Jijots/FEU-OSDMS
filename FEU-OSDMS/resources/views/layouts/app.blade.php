<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FEU-OSDMS | Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Force Public Sans globally across all elements */
        html, body, button, input, select, textarea, span, div, p, h1, h2, h3, h4 {
            font-family: 'Public Sans', sans-serif !important;
        }

        /* Sidebar Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); }
    </style>
</head>
<body class="h-full antialiased selection:bg-[#004d32] selection:text-[#FECB02]"
      x-data="{ sidebarOpen: false }">

    <div class="min-h-screen bg-[#F8FAFB] relative overflow-x-hidden flex flex-col">

        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-80 shadow-2xl"
             style="display: none;">
            @include('layouts.navigation')
        </div>

        <div class="flex-1 transition-all duration-300 ease-in-out min-h-screen flex flex-col"
             :class="sidebarOpen ? 'pl-80' : 'pl-0'">

            <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
                <div class="flex items-center gap-10">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                        <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
                    </a>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">
                            {{ str_contains(auth()->user()->email ?? '', 'admin') ? 'System Terminal' : 'Checkpoint Terminal' }}
                        </p>
                        <p class="text-xs font-black text-[#004d32] tracking-tighter uppercase">
                            {{ str_contains(auth()->user()->email ?? '', 'admin') ? 'ADMIN' : 'GUARD' }}-{{ auth()->id() }}
                        </p>
                    </div>
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
                </div>
            </div>

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
