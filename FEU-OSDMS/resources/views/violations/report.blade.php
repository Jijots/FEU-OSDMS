<x-app-layout>
    <div
        class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">
                    {{ str_contains(auth()->user()->email ?? '', 'admin') ? 'System Terminal' : 'Checkpoint Terminal' }}
                </p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">
                    {{ str_contains(auth()->user()->email ?? '', 'admin') ? 'ADMIN' : 'GUARD' }}-{{ auth()->id() }}
                </p>
            </div>
            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse border-4 border-red-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#F8FAFB]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-14 px-4 sm:px-0 gap-8">
                <div class="space-y-4">
                    <h1 class="text-7xl font-black text-slate-900 tracking-tighter leading-[1.1]">Disciplinary Hub</h1>
                    <p class="text-xl text-slate-400 font-medium tracking-tight">Active tracking and resolution of
                        student infractions.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('violations.create') }}"
                        class="inline-flex items-center justify-center gap-4 px-10 py-5 font-black rounded-xl text-[#004d32] transition-all no-underline bg-[#FECB02] hover:brightness-110 shadow-md hover:-translate-y-1 active:scale-95">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        FILE NEW REPORT
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 border-b border-slate-100 text-[12px] font-black text-slate-600 uppercase tracking-[0.2em]">
                                <th class="px-10 py-8 w-24 text-center">Case</th>
                                <th class="px-6 py-8">Student Details</th>
                                <th class="px-6 py-8">Offense Type</th>
                                <th class="px-6 py-8 text-center">Status</th>
                                <th class="px-10 py-8 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($violations as $violation)
                                <tr class="group hover:bg-slate-50/30 transition-all duration-300">
                                    <td class="px-10 py-8 text-center">
                                        <span
                                            class="text-sm font-black text-slate-300 group-hover:text-[#004d32] transition-colors">#{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-6 py-8">
                                        <div class="flex items-center gap-5">
                                            <div
                                                class="w-12 h-12 bg-[#F8FAFB] rounded-full flex items-center justify-center font-black text-slate-400 text-lg border border-slate-100">
                                                {{ substr($violation->student->name ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 text-lg">
                                                    {{ $violation->student->name ?? 'Unknown Student' }}</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                                    UID: {{ $violation->student->id_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-8">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xl font-black text-slate-900 tracking-tighter leading-none">{{ $violation->offense_type }}</span>
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 truncate max-w-xs">{{ $violation->description }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-8 text-center">
                                        @php
                                            $status = $violation->status ?? 'Pending';
                                            $style = 'background: #fffaf0; color: #9a3412; border: 1px solid #ffedd5;'; // Default Pending
                                            if ($status === 'Resolved') {
                                                $style =
                                                    'background: #f0fdf4; color: #166534; border: 1px solid #dcfce7;';
                                            } elseif ($status === 'Active') {
                                                $style =
                                                    'background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2;';
                                            }
                                        @endphp
                                        <span style="{{ $style }}"
                                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.15em] shadow-sm">{{ $status }}</span>
                                    </td>
                                    <td class="px-10 py-8">
                                        <div class="flex items-center justify-end gap-4">
                                            <a href="{{ route('violations.show', $violation->id) }}"
                                                class="inline-flex items-center justify-center px-6 py-3 bg-slate-900 text-white text-[9px] font-black rounded-xl shadow-md hover:bg-[#004d32] transition-all no-underline tracking-[0.15em]">
                                                REVIEW CASE
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-8 py-32 text-center text-slate-300 font-black uppercase tracking-[0.4em] text-xs">
                                        Zero Active Violations — Campus Secure</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
