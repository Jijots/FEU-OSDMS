<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 lg:px-12 py-10">

        @if(session('success'))
            <div class="mb-8 p-5 bg-green-50 border-2 border-green-200 rounded-2xl flex items-center gap-4 shadow-sm">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-base font-bold text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @error('csv_file')
            <div class="mb-8 p-5 bg-red-50 border-2 border-red-200 rounded-2xl flex items-center gap-4 shadow-sm">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-base font-bold text-red-800">Import Error: Ensure the file is a valid CSV format.</p>
            </div>
        @enderror

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Student Directory</h1>
                <p class="text-base text-slate-500 font-medium mt-1">Official registry of enrolled students and active history.</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right bg-white px-6 py-2 border-2 border-slate-200 rounded-xl shadow-sm hidden sm:block">
                    <p class="text-2xl font-extrabold text-[#004d32]">{{ $students->total() }}</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Enrolled</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border-2 border-slate-200 rounded-2xl flex flex-col md:flex-row justify-between gap-4 mb-8 shadow-sm">
            <form method="GET" action="{{ route('students.index') }}" class="relative w-full md:w-96">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name or ID number..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:border-[#004d32] focus:ring-0 text-sm font-semibold transition-colors placeholder:font-medium">
            </form>

            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="flex shrink-0">
                @csrf
                <input type="file" id="csv_upload" name="csv_file" accept=".csv" class="hidden" onchange="this.form.submit()">
                <button type="button" onclick="document.getElementById('csv_upload').click()" class="w-full md:w-auto px-6 py-3 bg-[#004d32] text-white font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm text-sm flex items-center justify-center gap-3 border-2 border-transparent">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Bulk Import CSV
                </button>
            </form>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl overflow-hidden shadow-sm mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Student Information</th>
                            <th class="px-8 py-5 text-sm font-bold text-slate-500 uppercase tracking-wide">Program Specialization</th>
                            <th class="px-8 py-5 text-right text-sm font-bold text-slate-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse($students as $student)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-slate-100 border-2 border-slate-200 rounded-xl flex items-center justify-center font-extrabold text-xl text-[#004d32] shrink-0 group-hover:bg-white group-hover:border-[#004d32] transition-colors">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-slate-900 leading-tight">{{ $student->name }}</p>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-xs font-bold text-slate-500 font-mono">{{ $student->id_number ?? 'NO-ID' }}</span>
                                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                            <span class="text-xs font-semibold text-slate-500">{{ $student->email }}</span>
                                        </div>

                                        <div class="flex items-center gap-4 mt-3">
                                            <span title="Active Violations" class="flex items-center gap-1.5 text-[10px] font-black uppercase {{ $student->violations_count > 0 ? 'text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-100' : 'text-slate-400' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                {{ $student->violations_count ?? 0 }} Violations
                                            </span>
                                            <span title="Incident Reports" class="flex items-center gap-1.5 text-[10px] font-black uppercase {{ $student->incidents_count > 0 ? 'text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-100' : 'text-slate-400' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                {{ $student->incidents_count ?? 0 }} Incidents
                                            </span>
                                            <span title="Lost Items Registered" class="flex items-center gap-1.5 text-[10px] font-black uppercase {{ $student->lost_items_count > 0 ? 'text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100' : 'text-slate-400' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                {{ $student->lost_items_count ?? 0 }} Assets
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide border-2 bg-slate-100 text-slate-700 border-slate-200">
                                    {{ $student->program_code ?? 'General' }}
                                </span>
                                <p class="text-sm font-bold text-slate-600 mt-1.5">{{ $student->specialization ?? 'Not Specified' }}</p>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('students.edit', $student->id) }}" class="p-2.5 text-slate-400 hover:text-[#004d32] hover:bg-slate-50 rounded-xl transition-all border-2 border-transparent hover:border-slate-200" title="Edit Student">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>

                                    <a href="{{ route('students.show', $student) }}" class="inline-block px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:text-[#004d32] hover:border-[#004d32] hover:bg-green-50 transition-all shadow-sm">
                                        View Profile
                                    </a>

                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Archive this student record?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all border-2 border-transparent hover:border-red-200" title="Remove Record">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-24 text-center">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p class="text-base font-bold text-slate-500">No students found. Upload a CSV to populate the directory.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $students->links() }}
        </div>

    </div>
</x-app-layout>
