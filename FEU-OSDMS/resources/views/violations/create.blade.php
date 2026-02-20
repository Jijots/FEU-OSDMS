<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10 text-center lg:text-left flex items-center gap-6">
                <a href="{{ route('violations.report') }}" class="p-4 bg-white rounded-full shadow-sm hover:bg-slate-50 transition-colors border border-slate-100">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter mb-1">File Disciplinary Report</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Official documentation of student infractions</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-10 shadow-sm border border-slate-100">
                <form action="{{ route('violations.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-[#004d32] uppercase tracking-widest mb-2 ml-1">Involved Student</label>
                            <select name="student_id" class="w-full px-6 py-4 bg-[#F8FAFB] border border-slate-100 rounded-xl font-bold text-sm text-slate-700 focus:ring-2 focus:ring-[#FECB02] focus:bg-white transition-all outline-none shadow-sm cursor-pointer" required>
                                <option value="" disabled selected>Select a student from the directory...</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->id_number }} — {{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="text-red-500 text-[10px] font-bold mt-2 ml-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-[#004d32] uppercase tracking-widest mb-2 ml-1">Offense Category</label>
                            <select name="offense_type" class="w-full px-6 py-4 bg-[#F8FAFB] border border-slate-100 rounded-xl font-bold text-sm text-slate-700 focus:ring-2 focus:ring-[#FECB02] focus:bg-white transition-all outline-none shadow-sm cursor-pointer" required>
                                <option value="" disabled selected>Classify the infraction...</option>
                                <option value="Dress Code Violation">Dress Code Violation</option>
                                <option value="Misconduct / Unruly Behavior">Misconduct / Unruly Behavior</option>
                                <option value="Vandalism / Property Damage">Vandalism / Property Damage</option>
                                <option value="Smoking / Vaping on Campus">Smoking / Vaping on Campus</option>
                                <option value="Other Infraction">Other Infraction</option>
                            </select>
                            @error('offense_type') <span class="text-red-500 text-[10px] font-bold mt-2 ml-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-[#004d32] uppercase tracking-widest mb-2 ml-1">Detailed Incident Report</label>
                            <textarea name="description" rows="5" placeholder="Provide a factual, objective summary of the incident..." class="w-full px-6 py-4 bg-[#F8FAFB] border border-slate-100 rounded-xl font-bold text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#FECB02] focus:bg-white transition-all outline-none shadow-sm resize-none" required></textarea>
                            @error('description') <span class="text-red-500 text-[10px] font-bold mt-2 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <button type="submit" class="px-12 py-5 bg-[#FECB02] text-[#004d32] rounded-xl font-black uppercase tracking-[0.2em] text-xs shadow-md hover:brightness-110 hover:-translate-y-1 transition-all active:scale-95">
                            Submit Official Report
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
