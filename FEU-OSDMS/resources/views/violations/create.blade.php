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
        <h2 class="text-[10px] font-black text-slate-400 tracking-widest uppercase">Disciplinary Offense Matrix</h2>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10 text-center">
                <h1 class="text-6xl font-black text-slate-900 tracking-tighter leading-none">Record Violation</h1>
                <div class="inline-flex items-center gap-3 mt-6 px-6 py-2 rounded-full bg-red-50">
                    <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                    <p class="text-[9px] font-black text-red-600 uppercase tracking-[0.4em]">Official Logging Sequence</p>
                </div>
            </div>

            <div class="bg-white p-14 rounded-[4rem] shadow-2xl border border-slate-100">
                <form action="{{ route('violations.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Target Identity</label>
                        <select name="student_id" required class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all text-sm appearance-none cursor-pointer">
                            <option value="">— Select Target Profile —</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->id_number }} - {{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="text-red-500 text-xs mt-2 ml-4 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Offense Classification</label>
                            <select name="offense_type" required class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all text-sm appearance-none cursor-pointer">
                                <option value="">— Assign Category —</option>
                                <option value="Uniform Violation">Uniform Violation</option>
                                <option value="ID Misuse">ID Misuse</option>
                                <option value="Unauthorized Access">Unauthorized Access</option>
                                <option value="Late Entry">Late Entry</option>
                                <option value="Major Offense">Major Offense</option>
                                <option value="Conduct">Conduct Violation</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Current Status</label>
                            <select name="status" class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all text-sm appearance-none cursor-pointer">
                                <option value="Pending">Pending Investigation</option>
                                <option value="Resolved">Resolved Immediately</option>
                                <option value="Escalated">Escalated for Review</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Initial Findings</label>
                            <input type="text" name="findings" placeholder="Enter findings..."
                                   class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Academic Term</label>
                            <input type="text" name="academic_term" placeholder="e.g., 2nd Sem 2026"
                                   class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Incident Report</label>
                        <textarea name="description" rows="4" placeholder="Detailed chronological breakdown..."
                                  class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 border-none font-medium text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Action Recommendation</label>
                        <textarea name="recommendation" rows="2" placeholder="Suggested sanctions or follow-ups..."
                                  class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 border-none font-medium text-slate-900 focus:ring-4 focus:ring-red-600/10 transition-all resize-none"></textarea>
                    </div>

                    <div class="flex gap-4 pt-8">
                        <a href="{{ route('violations.index') }}" class="flex-1 text-center py-6 font-black text-slate-300 uppercase tracking-widest text-xs hover:text-slate-600 transition-colors no-underline">Cancel</a>
                        <button type="submit" class="flex-[2] py-6 bg-[#991b1b] text-white rounded-full font-black uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-red-900/40 hover:brightness-110 transition-all">
                            Commit to Database
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
