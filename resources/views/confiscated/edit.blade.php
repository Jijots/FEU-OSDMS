<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('confiscated-items.index') }}" class="text-slate-400 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Update Item Status
                </h1>
            </div>
            <p class="text-sm text-slate-500 font-bold uppercase tracking-widest ml-9">Evidence Locker / Case Resolution</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="w-full h-48 bg-slate-100 flex items-center justify-center border-b border-slate-200">
                        @if($item->photo_path)
                            <img src="{{ Storage::url($item->photo_path) }}" alt="Evidence Photo" class="w-full h-full object-cover">
                        @else
                            <div class="text-slate-400 flex flex-col items-center">
                                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs font-bold uppercase tracking-wider">No Photo Logged</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Item / Contraband</p>
                            <p class="font-extrabold text-lg text-slate-900">{{ $item->item_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Confiscated From</p>
                            @if($item->student)
                                <p class="font-bold text-slate-800">{{ $item->student->name }}</p>
                                <p class="font-mono text-sm text-slate-500">{{ $item->student_id }}</p>
                            @else
                                <p class="font-bold text-slate-600">{{ $item->student_id ?? 'Unknown Owner' }}</p>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Seized By</p>
                                <p class="font-bold text-slate-700 text-sm">{{ $item->confiscated_by }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Date Logged</p>
                                <p class="font-bold text-slate-700 text-sm">{{ \Carbon\Carbon::parse($item->confiscated_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Storage Vault</p>
                            <p class="font-mono font-bold text-slate-700 text-sm">{{ $item->storage_location ?? 'N/A' }}</p>
                        </div>
                        @if($item->description)
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Description</p>
                            <p class="text-sm text-slate-600 italic whitespace-pre-wrap">{{ $item->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-8 py-4">
                        <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Case Resolution Ledger
                        </h2>
                    </div>

                    <form action="{{ route('confiscated-items.update', $item->id) }}" method="POST" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="status" class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Current Item Status</label>
                                <select name="status" id="status" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-bold transition-colors cursor-pointer">
                                    <option value="Safekeeping" {{ $item->status == 'Safekeeping' ? 'selected' : '' }}>🚨 Safekeeping (Currently in Locker)</option>
                                    <option value="Returned" {{ $item->status == 'Returned' ? 'selected' : '' }}>✅ Returned to Student</option>
                                    <option value="Disposed" {{ $item->status == 'Disposed' ? 'selected' : '' }}>🗑️ Permanently Disposed / Destroyed</option>
                                </select>
                            </div>

                            <div>
                                <label for="resolution_notes" class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Resolution Officer Notes</label>
                                <textarea name="resolution_notes" id="resolution_notes" rows="4" placeholder="Explain how this case was resolved. E.g., 'Vape confiscated and destroyed per handbook policy.' or 'ID returned to student after paying penalty fee.'"
                                    class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-medium transition-colors">{{ old('resolution_notes', $item->resolution_notes) }}</textarea>
                                <p class="text-xs text-slate-400 mt-2 font-medium">This record cannot be deleted once resolved to maintain an accurate audit trail.</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-10 pt-6 border-t border-slate-100">
                            <button type="button" onclick="if(confirm('WARNING: Are you sure you want to completely erase this record? This breaks the audit trail.')) document.getElementById('delete-form').submit();" class="text-sm font-bold text-slate-400 hover:text-red-600 transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Expunge Record
                            </button>

                            <div class="flex gap-3">
                                <a href="{{ route('confiscated-items.index') }}" class="px-6 py-3 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all">
                                    Cancel
                                </a>
                                <button type="submit" class="px-8 py-3 bg-slate-900 text-white font-bold rounded-xl shadow-lg hover:bg-slate-800 transition-all flex items-center gap-2 active:scale-95">
                                    Sign & Update Ledger
                                </button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('confiscated-items.destroy', $item->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
