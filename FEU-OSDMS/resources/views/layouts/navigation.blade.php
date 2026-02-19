<nav class="w-64 bg-feu-green text-white flex flex-col h-screen sticky top-0 shadow-xl z-20 flex-shrink-0">
    <div class="h-20 flex items-center px-6 border-b border-feu-green-dark bg-feu-green-dark/50">
        <div class="w-8 h-8 bg-feu-gold rounded flex items-center justify-center font-black text-feu-green shadow-inner mr-3">F</div>
        <a href="{{ route('dashboard') }}" class="font-feu text-xl tracking-tight text-white font-bold">
            FEU<span class="text-feu-gold"> OSDMS</span>
        </a>
    </div>

    <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto font-semibold">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-feu-gold text-feu-green-dark shadow-md' : 'text-gray-200 hover:bg-feu-green-dark hover:text-white' }}">
            Dashboard
        </a>
        <a href="{{ route('assets.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('assets.*') ? 'bg-feu-gold text-feu-green-dark shadow-md' : 'text-gray-200 hover:bg-feu-green-dark hover:text-white' }}">
            IntelliThings
        </a>
        <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('students.*') ? 'bg-feu-gold text-feu-green-dark shadow-md' : 'text-gray-200 hover:bg-feu-green-dark hover:text-white' }}">
            Student Profiles
        </a>
        <a href="{{ route('gate.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('gate.*') ? 'bg-feu-gold text-feu-green-dark shadow-md' : 'text-gray-200 hover:bg-feu-green-dark hover:text-white' }}">
            Gate Entry Log
        </a>
    </div>

    <div class="p-4 border-t border-feu-green-dark bg-feu-green-dark/30">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2 text-sm font-bold text-gray-300 hover:text-white transition">Log Out</button>
        </form>
    </div>
</nav>
