<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">OSD Command Center</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Students</p>
                    <p class="text-2xl font-black text-gray-900">{{ $studentCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <p class="text-xs font-bold text-gray-400 uppercase">Today's Gate Entries</p>
                    <p class="text-2xl font-black text-gray-900">{{ $gateEntryCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-600">
                    <p class="text-xs font-bold text-gray-400 uppercase">Pending Violations</p>
                    <p class="text-2xl font-black text-gray-900">{{ $pendingViolations }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600">
                    <p class="text-xs font-bold text-gray-400 uppercase">IntelliMatches</p>
                    <p class="text-2xl font-black text-gray-900">{{ $matchCount }} Found</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Instant Student Search</h3>
                    <form action="{{ route('students.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Type ID or Name..." 
                               class="w-full border-gray-200 rounded-lg">
                        <button class="mt-3 w-full bg-green-700 text-white font-bold py-2 rounded-lg">
                            Open Profile
                        </button>
                    </form>
                </div>
                
                <div class="bg-gray-900 p-6 rounded-xl shadow-sm text-white">
                    <h3 class="font-bold mb-4 text-gray-400 uppercase text-xs">Admin Shortcuts</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('gate.index') }}" class="bg-white/10 p-4 rounded-lg text-center hover:bg-white/20">
                            <span class="block text-lg">🚪</span>
                            <span class="text-xs font-bold">Gate Log</span>
                        </a>
                        <a href="{{ route('violations.report') }}" class="bg-white/10 p-4 rounded-lg text-center hover:bg-white/20">
                            <span class="block text-lg">📊</span>
                            <span class="text-xs font-bold">Analytics</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>