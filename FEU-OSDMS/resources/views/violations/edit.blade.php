<x-app-layout>
    <div class="py-12 bg-[#F8FAFB] min-h-screen" style="zoom: 0.90;">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10 flex items-center gap-6">
                <a href="{{ route('violations.show', $violation->id) }}" class="p-4 bg-white rounded-full shadow-sm hover:bg-slate-50 transition-colors border border-slate-100">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tighter mb-1">Adjudicate Case #{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-[10px] font-bold text-[#004d32] uppercase tracking-widest">Student: {{ $violation->student->name ?? 'Unknown' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-10 shadow-sm border border-slate-100">
                <form action="{{ route('violations.update', $violation->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-bold text-[#004d32] uppercase tracking-widest mb-2 ml-1">Case Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-[#F8FAFB] border border-slate-100 rounded-xl font-bold text-sm text-slate-700 focus:ring-2 focus:ring-[#FECB02] focus:bg-white transition-all outline-none shadow-sm cursor-pointer" required>
                            <option value="Active" {{ $violation->status === 'Active' ? 'selected' : '' }}>Active (Pending Resolution)</option>
                            <option value="Resolved" {{ $violation->status === 'Resolved' ? 'selected' : '' }}>Resolved (Case Closed)</option>
                            <option value="Dismissed" {{ $violation->status === 'Dismissed' ? 'selected' : '' }}>Dismissed (No Infraction)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-[#004d32] uppercase tracking-widest mb-2 ml-1">Official Findings / Remarks</label>
                        <textarea name="findings" rows="4" placeholder="Enter findings from the investigation..." class="w-full px-6 py-4 bg-[#F8FAFB] border border-slate-100 rounded-xl font-bold text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#FECB02] focus:bg-white transition-all outline-none shadow-sm resize-none">{{ $violation->findings }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-[#004d32] uppercase tracking-widest mb-2 ml-1">Final Disciplinary Action Taken</label>
                        <input type="text" name="final_action" value="{{ $violation->final_action }}" placeholder="e.g., Verbal Warning, 1-Week Suspension..." class="w-full px-6 py-4 bg-[#F8FAFB] border border-slate-100 rounded-xl font-bold text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#FECB02] focus:bg-white transition-all outline-none shadow-sm">
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <button type="submit" class="px-12 py-5 bg-[#004d32] text-white rounded-xl font-black uppercase tracking-[0.2em] text-xs shadow-md hover:bg-[#FECB02] hover:text-[#004d32] hover:-translate-y-1 transition-all active:scale-95">
                            Save Adjudication Data
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
