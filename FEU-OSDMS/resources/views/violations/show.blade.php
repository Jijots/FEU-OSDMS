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
                <p class="text-xs font-black text-[#004d32] tracking-tighter">ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse border-4 border-red-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#F8FAFB]" style="zoom: 0.90;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 p-6 bg-green-50 border-2 border-green-200 rounded-2xl flex items-center gap-4 shadow-sm">
                    <p class="text-sm font-black text-green-700 tracking-tight">{{ session('success') }}</p>
                </div>
            @endif

            <div class="mb-10 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <a href="{{ route('violations.report') }}" class="p-4 bg-white rounded-full shadow-sm hover:bg-slate-50 transition-colors border border-slate-100">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-5xl font-black text-slate-900 tracking-tighter mb-1">Case #{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Official Incident Dossier</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('violations.edit', $violation->id) }}" class="px-8 py-4 bg-[#FECB02] text-[#004d32] rounded-xl font-black uppercase tracking-[0.2em] text-[10px] shadow-sm hover:brightness-110 transition-all">
                        Update Case Status
                    </a>
                    <form action="{{ route('violations.destroy', $violation->id) }}" method="POST" onsubmit="return confirm('Permanently delete this case?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-8 py-4 bg-white border border-red-100 text-red-600 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] shadow-sm hover:bg-red-50 transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-10 shadow-sm border border-slate-100 space-y-10">

                <div class="grid grid-cols-2 gap-8 border-b border-slate-50 pb-8">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Involved Student</p>
                        <p class="text-2xl font-black text-slate-900">{{ $violation->student->name ?? 'Unknown' }}</p>
                        <p class="text-xs font-bold text-[#004d32] uppercase tracking-widest mt-1">UID: {{ $violation->student->id_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Current Status</p>
                        <span class="inline-flex items-center justify-center px-4 py-2 mt-1 rounded-lg text-[10px] font-black uppercase tracking-[0.15em] shadow-sm {{ $violation->status === 'Resolved' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ $violation->status }}
                        </span>
                    </div>
                </div>

                <div class="space-y-6 border-b border-slate-50 pb-8">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Offense Category</p>
                        <p class="text-xl font-bold text-slate-900">{{ $violation->offense_type }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Incident Description</p>
                        <div class="p-6 bg-[#F8FAFB] rounded-xl border border-slate-100 text-sm font-medium text-slate-700 leading-relaxed">
                            {{ $violation->description }}
                        </div>
                    </div>
                </div>

                <div class="space-y-6 bg-slate-50 p-8 rounded-2xl border border-slate-100">
                    <h3 class="text-[10px] font-black text-[#004d32] uppercase tracking-widest border-b border-slate-200 pb-3">OSD Adjudication & Findings</h3>

                    @if($violation->findings || $violation->final_action)
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Investigator Findings</p>
                                <p class="text-sm font-bold text-slate-900">{{ $violation->findings ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Final Action Taken</p>
                                <p class="text-sm font-bold text-[#004d32]">{{ $violation->final_action ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-xs font-bold text-slate-400 italic">No formal findings or resolutions have been recorded yet. Update the case status to proceed.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
