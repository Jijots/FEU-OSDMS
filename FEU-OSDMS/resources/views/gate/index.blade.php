<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <div class="mb-8">
                <h1 class="text-7xl font-black text-slate-900 tracking-tighter leading-none">Gate Entry Log</h1>
                <p class="text-xl text-slate-400 font-medium tracking-tight mt-2">Monitor and authorize physical campus access.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-2 border-green-200 text-[#004d32] px-8 py-5 rounded-[2rem] font-black tracking-widest uppercase text-[10px] flex items-center shadow-lg">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-4"></span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-12 rounded-[3.5rem] shadow-xl border border-slate-100">
                <h3 class="font-black text-[12px] text-slate-400 uppercase tracking-[0.2em] mb-8">Log New Entry</h3>
                <form action="{{ route('gate.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Student ID Number</label>
                            <input type="text" name="id_number" placeholder="e.g., 202312345" required
                                   class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-2 focus:ring-[#004d32] transition-all" value="{{ old('id_number') }}">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Entry Reason</label>
                            <select name="reason" class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-2 focus:ring-[#004d32] transition-all appearance-none cursor-pointer">
                                <option value="Forgot ID">Forgot ID</option>
                                <option value="Lost ID">Lost ID</option>
                                <option value="Damaged ID">Damaged ID</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full py-5 bg-[#FECB02] text-[#004d32] rounded-full font-black uppercase tracking-[0.2em] text-[11px] shadow-xl hover:brightness-110 transition-all">
                                Authorize Entry
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[3.5rem] shadow-[0_45px_90px_-20px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
                <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-[12px] text-slate-400 uppercase tracking-[0.2em]">Today's Activity</h3>
                    <span class="px-6 py-2.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $entries->count() }} Entries</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-10 py-6">Timestamp</th>
                                <th class="px-6 py-6">Student Data</th>
                                <th class="px-6 py-6 text-center">Authorization Reason</th>
                                <th class="px-10 py-6 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($entries as $entry)
                            <tr class="group hover:bg-slate-50/30 transition-all">
                                <td class="px-10 py-8 text-[11px] font-black text-slate-400 tracking-widest">{{ $entry->created_at->format('h:i A') }}</td>
                                <td class="px-6 py-8">
                                    <div class="flex flex-col">
                                        <span class="text-xl font-black text-slate-900">{{ $entry->student->name }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $entry->student->id_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-8 text-center">
                                    <span class="inline-flex items-center justify-center px-6 py-2 rounded-full text-[9px] font-black uppercase tracking-[0.2em] bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        {{ $entry->reason }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <span class="inline-flex items-center justify-center px-6 py-2 rounded-full text-[9px] font-black uppercase tracking-[0.2em] bg-green-50 text-green-700 border border-green-100">
                                        Verified
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-32 text-center text-slate-300 font-black uppercase tracking-[0.4em] text-xs">Terminal Idle — No Entries Today</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
