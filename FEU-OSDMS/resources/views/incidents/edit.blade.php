<x-app-layout>
    <div class="max-w-3xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-8 flex items-center justify-between border-b-2 border-slate-200 pb-6">
            <div>
                <a href="{{ route('incidents.show', $incident) }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Case Dossier
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Adjudicate Incident</h1>
            </div>
        </div>

        <form action="{{ route('incidents.update', $incident) }}" method="POST" class="bg-white border-2 border-slate-200 rounded-2xl p-8 lg:p-10 shadow-sm space-y-8">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Case Status</label>
                <select name="status" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0">
                    <option value="Pending Review" {{ $incident->status === 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                    <option value="Under Investigation" {{ $incident->status === 'Under Investigation' ? 'selected' : '' }}>Under Investigation</option>
                    <option value="Resolved" {{ $incident->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="Closed" {{ $incident->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">OSD Actions Taken</label>
                <textarea name="action_taken" rows="6" placeholder="Document all disciplinary or security actions taken to resolve this incident..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-base font-medium text-slate-800 focus:border-[#004d32] focus:ring-0 resize-none">{{ $incident->action_taken }}</textarea>
            </div>

            <div class="pt-6 border-t-2 border-slate-100 flex justify-end gap-4">
                <a href="{{ route('incidents.show', $incident) }}" class="px-8 py-4 bg-white border-2 border-slate-200 text-slate-600 text-base font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-[#004d32] text-white text-base font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm border-2 border-transparent">Save Updates</button>
            </div>
        </form>
    </div>
</x-app-layout>
