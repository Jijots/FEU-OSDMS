<x-app-layout>
    <div class="py-12 px-12 max-w-7xl mx-auto">

        <div class="flex justify-between items-end mb-12">
            <div>
                <h1 class="text-6xl font-black text-slate-900 tracking-tighter leading-tight">Students.</h1>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Verified Academic Records Directory</p>
            </div>
            <div class="text-right">
                <p class="text-4xl font-black text-[#004d32] tracking-tighter leading-none">{{ count($students) }}</p>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mt-1">Total Enrolled</p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-50">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-300 uppercase tracking-widest">Student Information</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-300 uppercase tracking-widest">Specialization</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-300 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($students as $student)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center font-black text-[#004d32]">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-lg font-black text-slate-900 tracking-tight leading-none">{{ $student->name }}</p>
                                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wider">{{ $student->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-sm font-bold text-slate-600">
                            {{ $student->specialization ?? 'N/A' }}
                        </td>
                        <td class="px-10 py-8 text-right">
                            <a href="{{ route('students.show', $student) }}" class="px-6 py-3 bg-[#004d32] text-white text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-feu-gold hover:text-[#004d32] transition-all">
                                View Profile
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
