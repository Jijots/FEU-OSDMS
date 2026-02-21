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
                <p class="text-base text-slate-500 font-medium mt-1">Official registry of enrolled students and academic records.</p>
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
                            <th class="px-8 py-5 text-right text-sm font-bold text-slate-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse($students as $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-slate-100 border-2 border-slate-200 rounded-xl flex items-center justify-center font-extrabold text-xl text-[#004d32] shrink-0">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-slate-900">{{ $student->name }}</p>
                                        <div class="flex items-center gap-3 mt-0.5">
                                            <span class="text-xs font-bold text-slate-500 font-mono">{{ $student->id_number ?? 'NO-ID' }}</span>
                                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                            <span class="text-xs font-semibold text-slate-500">{{ $student->email }}</span>
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
                                <a href="{{ route('students.show', $student) }}" class="inline-block px-6 py-3 bg-white border-2 border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:text-[#004d32] hover:border-[#004d32] hover:bg-green-50 transition-all shadow-sm">
                                    View Full Profile
                                </a>
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
