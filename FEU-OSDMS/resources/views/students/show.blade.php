<x-app-layout>
    <div class="max-w-6xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Student Directory
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Student Dossier</h1>
            </div>
            <span class="px-6 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wide border-2 bg-green-50 text-green-800 border-green-200 shadow-sm">
                {{ $student->program_code ?? 'Active Enrollment' }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm text-center">
                    <div class="w-28 h-28 mx-auto bg-slate-50 border-4 border-slate-200 rounded-full flex items-center justify-center font-extrabold text-5xl text-[#004d32] mb-5 shadow-inner">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-900 leading-tight">{{ $student->name }}</h2>
                    <p class="text-lg font-bold text-[#004d32] mt-2 font-mono tracking-wide">{{ $student->id_number ?? 'No ID Assigned' }}</p>

                    <div class="mt-6 pt-6 border-t-2 border-slate-100 text-left space-y-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Email Address</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $student->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Specialization</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $student->specialization ?? 'General' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">

                @if($student->lostItems->where('is_claimed', false)->count() > 0)
                <div class="bg-[#004d32] p-8 rounded-2xl border-4 border-[#003b26] shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-start gap-5 text-white">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0 border border-white/20">
                            <svg class="w-6 h-6 text-[#FECB02]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Smart Match Alert</h3>
                            <p class="text-base font-medium text-green-50 mt-1">This student currently has an active lost item report with a potential visual match awaiting verification.</p>
                        </div>
                    </div>
                    <a href="{{ route('assets.index') }}" class="px-8 py-4 bg-[#FECB02] text-[#004d32] rounded-xl font-bold text-sm hover:bg-yellow-400 transition-colors shrink-0 whitespace-nowrap border-2 border-transparent shadow-sm">
                        View Recovered Item
                    </a>
                </div>
                @endif

                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-4 mb-6">Disciplinary Records</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 border-b-2 border-slate-100">
                                    <th class="pb-4 text-xs font-bold uppercase tracking-wide">Incident Date</th>
                                    <th class="pb-4 text-xs font-bold uppercase tracking-wide">Offense Category</th>
                                    <th class="pb-4 text-xs font-bold uppercase tracking-wide text-center">Case Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-slate-50">
                                @forelse($student->violations as $violation)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-5 text-sm font-bold text-slate-700">{{ $violation->created_at->format('M d, Y') }}</td>
                                    <td class="py-5 text-sm font-bold text-slate-900">{{ $violation->offense_type }}</td>
                                    <td class="py-5 text-center">
                                        @php
                                            $status = $violation->status;
                                            $colors = [
                                                'Pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'Under Review' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'Resolved' => 'bg-green-100 text-green-800 border-green-200',
                                            ];
                                            $color = $colors[$status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                        @endphp
                                        <span class="inline-flex px-4 py-1.5 rounded-lg text-xs font-bold uppercase border-2 {{ $color }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-16 text-center">
                                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-base font-bold text-slate-500">No disciplinary records found. Student is in good standing.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
