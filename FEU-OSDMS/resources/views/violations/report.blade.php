<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 lg:px-12 py-10">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Violation Reports</h1>
                <p class="text-base text-slate-500 font-medium mt-1">Manage, search, and adjudicate student disciplinary cases.</p>
            </div>
            <a href="{{ route('violations.create') }}" class="px-6 py-3 bg-[#004d32] text-white font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm text-sm border-2 border-transparent">
                Log New Violation
            </a>
        </div>

        <div class="bg-white p-5 border-2 border-slate-200 rounded-2xl flex flex-col lg:flex-row justify-between gap-6 mb-8 shadow-sm">
            <form method="GET" action="{{ route('violations.report') }}" class="flex flex-col sm:flex-row gap-4 w-full">

                <div class="relative flex-1">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student name or ID..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:border-[#004d32] focus:ring-0 text-sm font-semibold transition-colors placeholder:font-medium">
                </div>

                <div class="flex gap-4">
                    <select name="status" class="w-full sm:w-48 bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 font-semibold text-slate-700 focus:border-[#004d32] focus:ring-0 text-sm transition-colors">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>

                    <button type="submit" class="px-6 py-3 bg-slate-800 text-white rounded-xl font-bold text-sm shadow-sm hover:bg-slate-700 transition-colors border-2 border-transparent">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('violations.report') }}" class="px-6 py-3 bg-white border-2 border-slate-200 text-slate-600 rounded-xl font-bold text-sm shadow-sm hover:bg-slate-50 transition-colors flex items-center justify-center">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Case / Date</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Student Info</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Offense Category</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide text-center">Status</th>
                            <th class="px-8 py-5 text-right text-sm font-bold text-slate-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse ($violations as $violation)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-900 tracking-tight">Case #{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-xs font-semibold text-slate-500 mt-1">{{ $violation->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-[#004d32]">{{ $violation->student->name ?? 'Unknown Student' }}</p>
                                    <p class="text-xs font-semibold text-slate-500 mt-1">{{ $violation->student->id_number ?? 'N/A' }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-700">{{ $violation->offense_type }}</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $status = $violation->status;
                                        $statusColors = [
                                            'Pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'Under Review' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'Resolved' => 'bg-green-100 text-green-800 border-green-200',
                                        ];
                                        $color = $statusColors[$status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                    @endphp
                                    <span class="inline-flex px-3 py-1.5 rounded-lg text-xs font-bold uppercase border {{ $color }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('violations.show', $violation->id) }}" class="inline-block px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:text-[#004d32] hover:border-[#004d32] hover:bg-green-50 transition-all shadow-sm">
                                        Review Case
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-32 text-center">
                                    <p class="text-base font-bold text-slate-500">No violations found matching the criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
