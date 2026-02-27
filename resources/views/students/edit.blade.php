<x-app-layout>
    <div class="max-w-4xl mx-auto px-8 py-12">

        <div class="mb-8">
            <a href="{{ route('students.index') }}" class="text-slate-400 hover:text-[#004d32] transition-colors flex items-center gap-2 font-bold text-sm uppercase tracking-widest">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back to Directory
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-4">Edit Student Profile</h1>
            <p class="text-slate-500 font-medium">Updating records for <span class="text-[#004d32]">{{ $student->name }}</span></p>
        </div>

        <form action="{{ route('students.update', $student->id) }}" method="POST" class="bg-white border-4 border-slate-200 rounded-3xl p-10 shadow-sm space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-black text-slate-700 uppercase tracking-wide mb-3">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl font-bold text-slate-900 focus:ring-0 focus:border-[#004d32] transition-colors" required>
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-700 uppercase tracking-wide mb-3">Student ID Number</label>
                    <input type="text" name="id_number" value="{{ old('id_number', $student->id_number) }}"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl font-mono font-bold text-slate-900 focus:ring-0 focus:border-[#004d32] transition-colors" required>
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-700 uppercase tracking-wide mb-3">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl font-bold text-slate-900 focus:ring-0 focus:border-[#004d32] transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-700 uppercase tracking-wide mb-3">Course / Department</label>
                    <input type="text" name="course" value="{{ old('course', $student->course) }}"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl font-bold text-slate-900 focus:ring-0 focus:border-[#004d32] transition-colors">
                </div>
            </div>

            <div class="pt-6 border-t-2 border-slate-100 flex justify-end gap-4">
                <button type="submit" class="px-10 py-4 bg-[#004d32] text-white rounded-2xl font-bold text-lg hover:bg-green-800 transition-all shadow-lg active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
