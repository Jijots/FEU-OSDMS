<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FEU-OSDMS | Terminal Access</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#F8FAFB] antialiased flex items-center justify-center p-12">
    <div class="w-full max-w-xl">
        {{ $slot }}
    </div>
</body>
</html>
