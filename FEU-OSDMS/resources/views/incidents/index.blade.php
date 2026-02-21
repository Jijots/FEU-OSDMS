<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 lg:px-12 py-10">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Incident Reports</h1>
                <p class="text-base text-slate-500 font-medium mt-1">Monitor and adjudicate campus security incidents.</p>
            </div>
            <a href="{{ route('incidents.create') }}" class="px-6 py-3 bg-[#004d32] text-white font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm text-sm border-2 border-transparent">
                Log New Incident
            </a>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Date & Location</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Category & Severity</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Reported By</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide text-center">Status</th>
                            <th class="px-8 py-5 text-right text-sm font-bold text-slate-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse ($incidents as $incident)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($incident->incident_date)->format('M d, Y') }}</p>
                                    <p class="text-xs font-semibold text-slate-500 mt-1">{{ $incident->incident_location }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800">{{ $incident->incident_category }}</p>
                                    @if($incident->severity == 'Critical' || $incident->severity == 'High')
                                        <p class="text-xs font-bold text-red-600 mt-1 uppercase">{{ $incident->severity }} Priority</p>
                                    @else
                                        <p class="text-xs font-bold text-slate-500 mt-1 uppercase">{{ $incident->severity }} Priority</p>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-[#004d32]">{{ $incident->reporter_name }}</p>
                                    <p class="text-xs font-semibold text-slate-500 mt-1">{{ $incident->reporter_affiliation ?? 'Guest/Other' }}</p>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $colors = [
                                            'Pending Review' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'Under Investigation' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'Resolved' => 'bg-green-100 text-green-800 border-green-200',
                                            'Closed' => 'bg-slate-200 text-slate-800 border-slate-300',
                                        ];
                                        $color = $colors[$incident->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                    @endphp
                                    <span class="inline-flex px-3 py-1.5 rounded-lg text-xs font-bold uppercase border-2 {{ $color }}">
                                        {{ $incident->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('incidents.show', $incident) }}" class="inline-block px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:text-[#004d32] hover:border-[#004d32] hover:bg-green-50 transition-all shadow-sm">
                                        Open Record
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-32 text-center">
                                    <p class="text-base font-bold text-slate-500">No security incidents logged.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
