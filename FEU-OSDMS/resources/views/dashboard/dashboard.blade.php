<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="font-black text-3xl text-gray-900 tracking-tight">System Command Center</h2>
                    <p class="text-gray-500 font-medium mt-1">Far Eastern University - Office of Student Discipline</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">System Status</p>
                    <div class="flex items-center justify-end gap-2 mt-1">
                        <span class="w-3 h-3 rounded-full bg-feu-green animate-pulse"></span>
                        <span class="font-semibold text-gray-700">All Modules Online</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Today's Gate Entries</p>
                        <p class="text-5xl font-black text-gray-900 mt-2">{{ $stats['total_entries'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-red-100 flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-red-500 uppercase tracking-widest">Active Violations</p>
                        <p class="text-5xl font-black text-red-600 mt-2">{{ $stats['active_violations'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-feu-gold-light flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-yellow-600 uppercase tracking-widest">IntelliThings Logs</p>
                        <p class="text-5xl font-black text-yellow-600 mt-2">{{ $stats['lost_items'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center flex flex-col justify-center items-center min-h-[300px]">
                    <div class="w-16 h-16 bg-feu-green/10 text-feu-green rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Security Guard Protocol</h3>
                    <p class="text-gray-500 mt-2 mb-6">Log student entries, manage gate overrides, and review recent campus access.</p>
                    <a href="{{ route('gate.index') }}" class="px-6 py-2 bg-gray-900 hover:bg-black text-white font-bold rounded-lg transition">Access Gate Log</a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center flex flex-col justify-center items-center min-h-[300px]">
                    <div class="w-16 h-16 bg-feu-gold/20 text-yellow-700 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">IntelliThings Subsystem</h3>
                    <p class="text-gray-500 mt-2 mb-6">Initiate AI visual matching protocol for lost and found items on campus.</p>
                    <a href="{{ route('assets.index') }}" class="px-6 py-2 bg-feu-green hover:bg-feu-green-dark text-white font-bold rounded-lg transition">Launch AI Matcher</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
