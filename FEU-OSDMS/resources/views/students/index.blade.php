<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-slate-200 z-40 px-8 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-6">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 rounded-lg transition-colors text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Student Directory</h1>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Admin Portal</p>
                <p class="text-sm font-bold text-[#004d32]">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-[#004d32] font-bold border border-green-200">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-8">

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
            <div class="relative w-full sm:w-96">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search by name or ID number..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 focus:border-[#004d32] focus:ring-1 focus:ring-[#004d32] text-sm font-medium placeholder-slate-400 transition-all">
            </div>

            <div class="flex gap-3 w-full sm:w-auto">
                <button class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import CSV
                </button>
                <button class="px-4 py-2.5 bg-[#004d32] text-white rounded-lg text-sm font-semibold hover:bg-green-800 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Student
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">ID Number</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Student Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Program</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-700 font-mono">202310790</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                            Tuazon, Jose Jerry Jr.
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold">
                                BSITWMA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-[#004d32] font-semibold text-sm transition-colors">View Profile</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-700 font-mono">202310124</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                            Dela Cruz, Juan
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold">
                                BSCS
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-[#004d32] font-semibold text-sm transition-colors">View Profile</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <p class="text-xs text-slate-500 font-medium">Showing <span class="font-bold text-slate-700">1</span> to <span class="font-bold text-slate-700">2</span> of <span class="font-bold text-slate-700">2</span> entries</p>
                <div class="flex gap-1">
                    <button class="px-3 py-1 rounded border border-slate-200 text-slate-400 text-sm font-medium hover:bg-slate-100 transition-colors" disabled>Prev</button>
                    <button class="px-3 py-1 rounded border border-[#004d32] bg-[#004d32] text-white text-sm font-medium shadow-sm">1</button>
                    <button class="px-3 py-1 rounded border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-100 transition-colors">Next</button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
