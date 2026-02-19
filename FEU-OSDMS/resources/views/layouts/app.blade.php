<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>FEU OSDMS</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <style>
            @font-face {
                font-family: 'DellaRobbia BT';
                src: url('/fonts/DellaRobbiaBT.ttf') format('truetype');
                font-weight: normal;
                font-style: normal;
            }
            .font-feu { font-family: 'DellaRobbia BT', serif; }
        </style>

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'sans-serif'] },
                        colors: {
                            'feu-green': '#006341',
                            'feu-green-dark': '#004d32',
                            'feu-gold': '#FDBA31',
                        }
                    }
                }
            }
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 flex min-h-screen overflow-x-hidden">

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col min-h-screen">
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-30 px-8 py-4 flex justify-between items-center">
                <div class="font-bold text-gray-800 text-lg">
                    {{ $header ?? 'Dashboard' }}
                </div>
                <div class="flex items-center gap-4 text-sm font-bold text-gray-500">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    {{ Auth::user()->name }}
                </div>
            </header>

            <main class="p-8 flex-1">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
