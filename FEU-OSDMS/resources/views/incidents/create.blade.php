<x-app-layout>
    <div class="max-w-4xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex items-center justify-between border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('incidents.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Registry
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Log Security Incident</h1>
            </div>
        </div>

        <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border-2 border-slate-200 rounded-2xl p-8 lg:p-10 shadow-sm space-y-8">
            @csrf

            <div>
                <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-2 mb-4">1. Involved Student</h3>
                <div class="bg-slate-50 p-6 rounded-2xl border-2 border-slate-100">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Assign Incident to Student</label>
                    <select name="student_id" class="w-full bg-white border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0 appearance-none" required>
                        <option value="">-- Select involved student --</option>
                        @foreach(\App\Models\User::where('role', 'student')->orderBy('name')->get() as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->id_number }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-2 font-medium italic">* This incident will appear on this student's disciplinary history and the dashboard counters.</p>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-2 mb-4">2. Reporter Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                        <input type="text" name="reporter_name" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                        <input type="email" name="reporter_email" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Affiliation / Program</label>
                        <input type="text" name="reporter_affiliation" placeholder="e.g. BSIT, Staff, Guard" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-2 mb-4">3. Incident Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Date of Incident</label>
                        <input type="date" name="incident_date" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Location</label>
                        <input type="text" name="incident_location" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                        <select name="incident_category" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0" required>
                            <option value="Theft">Theft / Loss of Property</option>
                            <option value="Vandalism">Vandalism</option>
                            <option value="Altercation">Physical/Verbal Altercation</option>
                            <option value="Medical">Medical Emergency</option>
                            <option value="Unauthorized Entry">Unauthorized Entry</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Severity Level</label>
                        <select name="severity" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold focus:border-[#004d32] focus:ring-0" required>
                            <option value="Routine">Low</option>
                            <option value="High">High Priority</option>
                            <option value="Critical">Critical Emergency</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Full Description</label>
                    <textarea name="description" rows="5" placeholder="Detail exactly what happened..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-base font-medium focus:border-[#004d32] focus:ring-0 resize-none" required></textarea>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#004d32] uppercase tracking-wide border-b-2 border-slate-100 pb-2 mb-4">4. Photographic Evidence (Optional)</h3>
                <input type="file" name="evidence" accept="image/*" class="w-full bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl p-6 text-sm font-semibold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-[#004d32] file:text-white hover:file:bg-green-800 transition-all cursor-pointer">
            </div>

            <div class="pt-6 border-t-2 border-slate-100 flex justify-end gap-4">
                <a href="{{ route('incidents.index') }}" class="px-8 py-4 bg-white border-2 border-slate-200 text-slate-600 text-base font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-[#004d32] text-white text-base font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm">Log Incident</button>
            </div>
        </form>
    </div>
</x-app-layout>
