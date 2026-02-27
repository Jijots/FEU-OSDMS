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
        body { font-family: 'Public Sans', sans-serif !important; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    </style>
</head>
<body class="h-full antialiased bg-[#F8FAFB] text-slate-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen w-full overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0 w-80 border-r-2' : '-translate-x-full w-0 border-r-0'"
             class="fixed lg:relative inset-y-0 left-0 z-50 bg-[#004d32] transition-all duration-300 ease-in-out shrink-0 border-[#003b26] shadow-2xl lg:shadow-none overflow-hidden">

            <div class="w-80 h-full flex flex-col">
                @include('layouts.navigation')
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
             class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden backdrop-blur-sm" x-cloak></div>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            @include('layouts.header')

            <main class="flex-1 overflow-y-auto w-full">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
