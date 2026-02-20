<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FEU-OSDMS | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Creates a subtle texture overlay over the FEU Green */
        .bg-texture {
            background-color: #004d32;
            background-image: radial-gradient(circle at center, rgba(255,255,255,0.05) 0%, transparent 70%),
                              url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.08'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="h-full bg-texture antialiased flex items-center justify-center p-12">
    <div class="w-full max-w-xl relative z-10">
        {{ $slot }}
    </div>
</body>
</html>
