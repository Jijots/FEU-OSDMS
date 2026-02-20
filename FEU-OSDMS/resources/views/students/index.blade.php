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
                <h1 class="text-7xl font-black text-slate-900 tracking-tighter leading-none">Student Registry</h1>
                <p class="text-xl text-slate-400 font-medium tracking-tight mt-2">Centralized database for student profiling and tracking.</p>
            </div>

            <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100">
                <form method="GET" action="{{ route('students.index') }}" class="flex gap-4">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Scan by ID Number or Name..."
                           class="flex-1 px-10 py-6 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-[#004d32]/10 transition-all text-sm">
                    <button type="submit" class="bg-[#004d32] text-white px-16 py-6 rounded-full font-black uppercase tracking-widest text-xs shadow-xl shadow-green-900/20 hover:brightness-110 transition-all">
                        Execute Query
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-[3.5rem] shadow-[0_45px_90px_-20px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
                <div class="p-10 border-b border-slate-50">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                        Database Return: <span class="text-[#004d32]">{{ $students->count() }} Profiles</span>
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-10 py-6">ID Number</th>
                                <th class="px-6 py-6">Identity Data</th>
                                <th class="px-6 py-6">Academic Program</th>
                                <th class="px-6 py-6 text-center">Sector</th>
                                <th class="px-10 py-6 text-right">System Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($students as $student)
                                <tr class="group hover:bg-slate-50/30 transition-all">
                                    <td class="px-10 py-8 font-black text-slate-300 tracking-widest">{{ $student->id_number }}</td>
                                    <td class="px-6 py-8 font-black text-xl text-slate-900 tracking-tight">{{ $student->name }}</td>
                                    <td class="px-6 py-8 font-bold text-slate-500">{{ $student->program_code ?? '—' }}</td>
                                    <td class="px-6 py-8 text-center font-bold text-slate-400 uppercase tracking-widest text-[10px]">{{ $student->campus ?? 'Main' }}</td>
                                    <td class="px-10 py-8 text-right">
                                        <a href="{{ route('students.show', $student->id) }}"
                                           class="inline-flex items-center justify-center px-8 py-3 bg-slate-900 text-white hover:bg-[#004d32] rounded-full text-[9px] font-black uppercase tracking-[0.2em] transition-all no-underline">
                                            Access Profile
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-32 text-center text-slate-300 font-black uppercase tracking-[0.4em] text-xs">
                                        {{ $search ? 'Query Failed — No Match Found' : 'Registry Empty' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students instanceof \Illuminate\Pagination\Paginator)
                <div class="p-8 border-t border-slate-50 bg-slate-50/30">
                    {{ $students->appends(['search' => $search ?? ''])->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
