<x-app-layout>
    <div class="py-12 bg-[#FCFCFC]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-10 gap-6">
                <div class="space-y-1">
                    <h1 class="text-6xl font-black text-slate-900 tracking-tighter leading-none">Student Directory</h1>
                    <p class="text-lg text-slate-400 font-medium tracking-tight text-uppercase">Centralized access to digitized disciplinary records.</p>
                </div>

                <form action="{{ route('students.index') }}" method="GET" class="relative w-full lg:w-96">
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Search by Name or ID..."
                           class="w-full pl-14 pr-6 py-4 rounded-3xl border-none bg-white shadow-xl shadow-slate-200/50 focus:ring-4 focus:ring-[#004d32]/10 transition-all font-bold text-slate-700">
                    <svg class="w-6 h-6 absolute left-5 top-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>
            </div>

            <div class="bg-white rounded-[3.5rem] shadow-[0_45px_90px_-20px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            <th class="px-10 py-8">Student Identification</th>
                            <th class="px-6 py-8">Academic Track</th>
                            <th class="px-6 py-8 text-center">Record Status</th>
                            <th class="px-10 py-8 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($students as $student)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="px-10 py-10">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-black text-slate-900 tracking-tight leading-none">{{ $student->name }}</span>
                                    <span class="text-xs font-bold text-slate-300 mt-2 uppercase tracking-widest">UID: {{ $student->id_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-10">
                                <span class="text-sm font-bold text-slate-500 uppercase">{{ $student->course_or_department ?? 'General Education' }}</span>
                            </td>
                            <td class="px-6 py-10 text-center">
                                <span class="px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest {{ $student->violations_count > 0 ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-green-700 border border-green-100' }}">
                                    {{ $student->violations_count > 0 ? 'Under Review' : 'Clear Standing' }}
                                </span>
                            </td>
                            <td class="px-10 py-10 text-right">
                                <a href="{{ route('students.show', $student->id) }}" class="inline-flex items-center px-8 py-3 bg-[#004d32] text-white text-[10px] font-black rounded-2xl shadow-lg hover:brightness-110 transition-all uppercase tracking-widest">
                                    Open Dossier
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-32 text-center text-slate-200 font-black uppercase tracking-[0.4em]">No Active Transcripts Found</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
