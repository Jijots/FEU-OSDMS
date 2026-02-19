<!-- Vertical Green Sidebar Navigation -->
<nav x-data="{ sidebarOpen: window.innerWidth >= 768 }"
     class="fixed left-0 top-0 h-screen w-64 md:w-72 bg-gradient-to-b from-green-700 to-green-900 shadow-lg z-40 overflow-y-auto transition-all duration-300"
     :class="{ 'w-0': !sidebarOpen, 'w-64 md:w-72': sidebarOpen }"
     @resize.window="sidebarOpen = window.innerWidth >= 768">

    <!-- Sidebar Header with Logo/Profile -->
    <div class="p-6 border-b border-green-600">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-green-900">
                    🛡️
                </div>
                <span class="text-white font-bold text-lg hidden md:inline">OSD</span>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="text-white text-sm">
            <div class="font-semibold">{{ Auth::user()->name }}</div>
            <div class="text-green-200 text-xs">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="px-4 py-6 space-y-2">
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('dashboard') ? 'bg-green-600 font-bold' : 'hover:bg-green-700' }}">
            <span class="text-lg mr-3">📊</span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('assets.index') }}"
           class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('assets.*') ? 'bg-green-600 font-bold' : 'hover:bg-green-700' }}">
            <span class="text-lg mr-3">🔍</span>
            <span>IntelliThings</span>
        </a>

        <a href="{{ route('students.index') }}"
           class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('students.*') ? 'bg-green-600 font-bold' : 'hover:bg-green-700' }}">
            <span class="text-lg mr-3">👥</span>
            <span>Students</span>
        </a>

        <a href="{{ route('gate.index') }}"
           class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('gate.*') ? 'bg-green-600 font-bold' : 'hover:bg-green-700' }}">
            <span class="text-lg mr-3">🚪</span>
            <span>Gate Log</span>
        </a>

        @auth
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('violations.index') }}"
               class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('violations.*') ? 'bg-green-600 font-bold' : 'hover:bg-green-700' }}">
                <span class="text-lg mr-3">⚠️</span>
                <span>Violations</span>
            </a>

            <a href="{{ route('violations.report') }}"
               class="flex items-center px-4 py-3 rounded-lg text-white transition {{ request()->routeIs('violations.report') ? 'bg-green-600 font-bold' : 'hover:bg-green-700' }}">
                <span class="text-lg mr-3">📋</span>
                <span>Reports</span>
            </a>
            @endif
        @endauth
    </div>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 px-4 py-4 border-t border-green-600 bg-green-800">
        <div class="space-y-2">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center px-4 py-2 rounded-lg text-white text-sm hover:bg-green-700">
                <span class="mr-2">⚙️</span>
                <span>Profile</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-2 rounded-lg text-white text-sm hover:bg-green-700 transition">
                    <span class="mr-2">🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar Toggle Button -->
<button @click="document.querySelector('nav').style.left = '0'"
        class="fixed bottom-6 right-6 md:hidden bg-green-600 hover:bg-green-700 text-white p-3 rounded-full shadow-lg z-30 transition"
        x-cloak>
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>
