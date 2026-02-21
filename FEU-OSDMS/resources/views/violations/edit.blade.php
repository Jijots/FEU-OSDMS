<x-app-layout>
    <div class="max-w-3xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex items-center justify-between border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('violations.show', $violation->id) }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Case Dossier
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Adjudicate Case #{{ str_pad($violation->id, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>
        </div>

        <div class="bg-white border-2 border-slate-200 rounded-2xl p-8 lg:p-10 shadow-sm">

            <div class="mb-8 pb-6 border-b-2 border-slate-100">
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-1">Student Record</p>
                <p class="text-xl font-bold text-[#004d32]">{{ $violation->student->name ?? 'Unknown Student' }} (ID: {{ $violation->student->id_number ?? 'N/A' }})</p>
            </div>

            <form action="{{ route('violations.update', $violation->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Case Status</label>
                    <select name="status" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 transition-colors">
                        <option value="Pending" {{ $violation->status === 'Pending' ? 'selected' : '' }}>Pending Processing</option>
                        <option value="Under Review" {{ $violation->status === 'Under Review' ? 'selected' : '' }}>Under Investigation/Review</option>
                        <option value="Resolved" {{ $violation->status === 'Resolved' ? 'selected' : '' }}>Case Resolved / Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Investigator Findings</label>
                    <textarea name="findings" rows="4" placeholder="Enter formal findings from the investigation..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-base font-medium text-slate-800 focus:border-[#004d32] focus:ring-0 placeholder:font-medium transition-colors resize-none">{{ $violation->findings }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Final Disciplinary Action</label>
                    <input type="text" name="final_action" value="{{ $violation->final_action }}" placeholder="e.g., Verbal Warning, 1-Week Suspension..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 placeholder:font-medium transition-colors">
                </div>

                <div class="pt-6 border-t-2 border-slate-100 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('violations.show', $violation->id) }}" class="px-8 py-4 text-center text-base font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                    <button type="submit" class="px-10 py-4 bg-[#004d32] text-white text-base font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm border-2 border-transparent">
                        Save Case Updates
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
