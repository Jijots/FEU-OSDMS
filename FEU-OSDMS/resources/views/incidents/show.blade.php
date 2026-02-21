<x-app-layout>
    <div class="max-w-6xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('incidents.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Reports
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Security Record #{{ str_pad($incident->id, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>

            <div class="flex items-center gap-4">
                <span class="px-5 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wide border-2 bg-slate-100 border-slate-200 text-slate-800">
                    Status: {{ $incident->status }}
                </span>

                <a href="{{ route('incidents.edit', $incident) }}" class="px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl text-sm hover:bg-[#004d32] transition-colors shadow-sm flex items-center gap-2 border-2 border-transparent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Update Case
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="space-y-8">
                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-5">Reporter Details</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Full Name</p>
                            <p class="text-base font-bold text-slate-900">{{ $incident->reporter_name }}</p>
                        </div>
                        <div class="flex gap-8">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Email</p>
                                <p class="text-base font-semibold text-slate-700">{{ $incident->reporter_email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Affiliation</p>
                                <p class="text-base font-semibold text-slate-700">{{ $incident->reporter_affiliation ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-5">Event Documentation</h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category</p>
                                <p class="text-base font-bold text-slate-900">{{ $incident->incident_category }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Severity</p>
                                <p class="text-base font-bold text-red-600">{{ $incident->severity }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Date</p>
                                <p class="text-base font-bold text-slate-900">{{ \Carbon\Carbon::parse($incident->incident_date)->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Location</p>
                                <p class="text-base font-bold text-slate-900">{{ $incident->incident_location }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-2">Narrative</p>
                            <div class="bg-slate-50 p-5 rounded-xl border-2 border-slate-100 text-base font-medium text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $incident->description }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-6">OSD Actions & Resolution</h3>
                    @if($incident->action_taken)
                        <div class="bg-green-50 p-6 rounded-xl border-2 border-green-200">
                            <p class="text-xs font-bold text-green-700 uppercase tracking-wide mb-2">Final Actions Taken</p>
                            <p class="text-base font-medium text-green-900 whitespace-pre-wrap">{{ $incident->action_taken }}</p>
                        </div>
                    @else
                        <div class="py-8 text-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50">
                            <p class="text-sm font-bold text-slate-500 max-w-xs mx-auto">No actions recorded yet. Click 'Update Case' to log resolution details.</p>
                        </div>
                    @endif
                </div>

                @if($incident->evidence_path)
                <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-3 mb-5">Photographic Evidence</h3>
                    <img src="{{ asset('storage/' . $incident->evidence_path) }}" class="w-full rounded-xl border-2 border-slate-200 shadow-sm">
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
