<x-app-layout>
    <div class="max-w-6xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('violations.report') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Violation Reports
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Case #{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>

            <div class="flex items-center gap-4">
                @php
                    $status = $violation->status;
                    $statusColors = [
                        'Pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                        'Under Review' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'Resolved' => 'bg-green-100 text-green-800 border-green-200',
                    ];
                    $color = $statusColors[$status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                @endphp
                <span class="px-5 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wide border-2 {{ $color }} hidden sm:block">
                    Status: {{ $status }}
                </span>

                <form action="{{ route('violations.destroy', $violation->id) }}" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete this case dossier? This action cannot be undone.');">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2.5 text-red-600 bg-white border-2 border-red-200 hover:bg-red-50 hover:border-red-300 font-bold rounded-xl text-sm transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span class="hidden sm:inline">Delete</span>
                    </button>
                </form>

                <a href="{{ route('violations.nte', $violation->id) }}" target="_blank" class="px-6 py-2.5 bg-white text-[#004d32] border-2 border-[#004d32] font-bold rounded-xl text-sm hover:bg-green-50 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Generate NTE
                </a>

                <a href="{{ route('violations.edit', $violation->id) }}" class="px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl text-sm hover:bg-[#004d32] transition-colors shadow-sm flex items-center gap-2 border-2 border-transparent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Update Case
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="space-y-8">

                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-5">Student Information</h3>
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-slate-100 border-2 border-slate-200 rounded-xl flex items-center justify-center font-extrabold text-2xl text-[#004d32]">
                            {{ substr($violation->student->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xl font-bold text-slate-900">{{ $violation->student->name ?? 'Unknown Student' }}</p>
                            <p class="text-sm font-semibold text-slate-500 mt-1 font-mono">{{ $violation->student->id_number ?? 'N/A' }}</p>
                            <p class="text-sm font-semibold text-slate-500 mt-1">{{ $violation->student->program ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-5">Incident Details</h3>
                    <div class="space-y-6">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Offense Category</span>
                            <span class="inline-block px-4 py-1.5 bg-red-50 text-red-700 border-2 border-red-100 rounded-lg text-sm font-bold">
                                {{ $violation->offense_type }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-2">Description of Event</span>
                            <div class="bg-slate-50 p-5 rounded-xl border-2 border-slate-100 text-base font-medium text-slate-700 leading-relaxed whitespace-pre-wrap">
                                {{ $violation->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm h-fit">
                <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-6">OSD Adjudication & Findings</h3>

                @if($violation->findings || $violation->final_action)
                    <div class="space-y-8">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-2">Investigator Findings</p>
                            <div class="bg-slate-50 p-5 rounded-xl border-2 border-slate-100 text-base font-medium text-slate-700 leading-relaxed whitespace-pre-wrap">
                                {{ $violation->findings ?? 'No formal findings logged yet.' }}
                            </div>
                        </div>

                        <div class="p-6 bg-green-50 border-2 border-green-200 rounded-xl">
                            <p class="text-xs font-bold text-green-700 uppercase tracking-wide mb-2">Final Action Taken</p>
                            <p class="text-lg font-extrabold text-[#004d32]">{{ $violation->final_action ?? 'Pending final resolution' }}</p>
                        </div>
                    </div>
                @else
                    <div class="py-12 text-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-sm font-bold text-slate-500 max-w-xs mx-auto">No formal findings or resolutions have been recorded yet. Click 'Update Case' to adjudicate.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
