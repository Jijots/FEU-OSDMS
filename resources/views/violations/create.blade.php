<x-app-layout>
    <div class="max-w-3xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex items-center justify-between border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('violations.report') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Violation Reports
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Log Disciplinary Incident</h1>
            </div>
            <span class="px-4 py-2 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm border-2 border-slate-200">New Entry</span>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl p-8 lg:p-10 shadow-sm">
            <form action="{{ route('violations.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Student ID Number</label>
                        <input type="text" name="student_id" placeholder="e.g. 202310790" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 placeholder:font-medium transition-colors" required>
                        @error('student_id') <span class="text-red-500 text-sm font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Offense Category</label>
                        <select name="offense_type" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 transition-colors" required>
                            <option value="" disabled selected>Select category...</option>
                            <option value="Dress Code">Dress Code Violation</option>
                            <option value="ID Policy">ID Policy Violation</option>
                            <option value="Behavioral">Behavioral Misconduct</option>
                            <option value="Academic Integrity">Academic Integrity</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('offense_type') <span class="text-red-500 text-sm font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Detailed Incident Report</label>
                    <textarea name="description" rows="5" placeholder="Provide a factual, objective summary of the incident..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-base font-medium text-slate-800 focus:border-[#004d32] focus:ring-0 placeholder:font-medium transition-colors resize-none" required></textarea>
                    @error('description') <span class="text-red-500 text-sm font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t-2 border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('violations.report') }}" class="px-8 py-4 text-center text-base font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                    <button type="submit" class="px-10 py-4 bg-[#004d32] text-white text-base font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm border-2 border-transparent">
                        Submit Official Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
