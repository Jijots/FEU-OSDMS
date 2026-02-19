<nav x-data="{ open: false }" class="bg-feu-green border-b border-feu-green-dark shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 bg-feu-gold rounded flex items-center justify-center font-black text-feu-green text-xl shadow-inner">
                        F
                    </div>
                    <a href="{{ route('dashboard') }}" class="font-black text-2xl tracking-tight text-white">
                        FEU<span class="text-feu-gold"> OSDMS</span>
                    </a>
                </div>

                <div class="hidden sm:space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-feu-gold text-feu-gold' : 'border-transparent text-gray-200 hover:text-white hover:border-gray-300' }} text-sm font-semibold transition">
                        Dashboard
                    </a>
                    <a href="{{ route('assets.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('assets.*') ? 'border-feu-gold text-feu-gold' : 'border-transparent text-gray-200 hover:text-white hover:border-gray-300' }} text-sm font-semibold transition">
                        IntelliThings
                    </a>
                    <a href="{{ route('students.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('students.*') ? 'border-feu-gold text-feu-gold' : 'border-transparent text-gray-200 hover:text-white hover:border-gray-300' }} text-sm font-semibold transition">
                        Student Profiles
                    </a>
                    <a href="{{ route('gate.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('gate.*') ? 'border-feu-gold text-feu-gold' : 'border-transparent text-gray-200 hover:text-white hover:border-gray-300' }} text-sm font-semibold transition">
                        Gate Entry Log
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-feu-gold/50 text-sm leading-4 font-bold rounded-lg text-feu-gold bg-feu-green-dark hover:bg-feu-green focus:outline-none transition">
                            <div>{{ Auth::user()->name ?? 'Administrator' }}</div>
                            <svg class="ml-2 h-4 w-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
