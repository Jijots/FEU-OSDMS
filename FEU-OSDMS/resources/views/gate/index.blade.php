<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 lg:px-12 py-12">

        @if(session('warning'))
            <div class="mb-10 p-6 bg-red-50 border-2 border-red-200 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-3 h-3 bg-red-600 rounded-full animate-pulse"></div>
                <p class="text-base font-bold text-red-800 tracking-wide uppercase">System Alert: {{ session('warning') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <div class="lg:col-span-5 lg:sticky lg:top-32 space-y-6">

                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Gate Entry Scanner</h1>
                    <p class="text-base text-slate-500 font-medium mt-2">Scan student ID or manually log entry to authorize access.</p>
                </div>

                <button type="button" id="start-scanner-btn" onclick="startScanner()" class="w-full py-4 bg-white border-2 border-slate-200 text-slate-700 hover:text-[#004d32] rounded-xl font-bold text-base shadow-sm hover:border-slate-300 hover:bg-slate-50 transition-all flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    Enable Camera Scanner
                </button>

                <div id="scanner-container" class="hidden mb-6">
                    <div id="reader" class="rounded-2xl overflow-hidden border-4 border-slate-200 shadow-sm bg-slate-50"></div>
                </div>

                <form id="gate-entry-form" action="{{ route('gate.store') }}" method="POST" class="bg-white border-2 border-slate-200 rounded-2xl p-8 shadow-sm space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Student ID Number</label>
                        <input type="text" id="id_number_input" name="id_number" placeholder="Scan or type ID number..."
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl font-mono text-lg font-bold text-slate-900 focus:ring-0 focus:border-[#004d32] transition-colors" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Reason for Entry</label>
                        <select name="reason" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl font-bold text-base text-slate-800 focus:ring-0 focus:border-[#004d32] appearance-none transition-colors">
                            <option value="Forgot ID">Forgot ID</option>
                            <option value="Lost ID">Lost ID</option>
                            <option value="Visitor">Visitor</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#004d32] text-white rounded-xl font-bold text-base shadow-sm hover:bg-green-800 transition-colors mt-2">
                        Authorize Entry
                    </button>
                </form>
            </div>

            <div class="lg:col-span-7 space-y-6">

                <div class="flex items-center justify-between border-b-2 border-slate-200 pb-4 mb-6">
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Recent Gate Entries</h3>
                    <div class="flex items-center gap-2 bg-green-50 px-3 py-1.5 rounded-lg border border-green-200">
                        <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-bold text-green-700 uppercase tracking-wide">Live Feed</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($entries as $entry)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 bg-white rounded-2xl border-2 border-slate-200 shadow-sm hover:shadow-md transition-all group gap-4">

                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center font-bold text-xl text-[#004d32] border-2 border-slate-200 shrink-0">
                                    {{ substr($entry->student->name ?? 'V', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-lg tracking-tight leading-tight">{{ $entry->student->name ?? 'Visitor' }}</p>
                                    <p class="text-sm font-semibold text-slate-500 mt-1 font-mono">ID: {{ $entry->student->id_number ?? 'TEMPORARY-ACCESS' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto mt-2 sm:mt-0 pt-4 sm:pt-0 border-t-2 border-slate-100 sm:border-0">
                                <span class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide border-2 {{ $entry->reason === 'Forgot ID' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                                    {{ $entry->reason }}
                                </span>

                                <div class="flex items-center gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('gate.edit', $entry->id) }}" class="p-2 text-slate-400 hover:text-[#004d32] hover:bg-slate-50 rounded-lg transition-colors border-2 border-transparent hover:border-slate-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('gate.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Delete this entry?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border-2 border-transparent hover:border-red-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center border-2 border-dashed border-slate-200 rounded-2xl bg-white">
                            <p class="text-base font-bold text-slate-500">No active gate entries at this time.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function startScanner() {
            const scannerContainer = document.getElementById('scanner-container');
            const idInput = document.getElementById('id_number_input');
            const startBtn = document.getElementById('start-scanner-btn');

            scannerContainer.classList.remove('hidden');
            startBtn.classList.add('hidden');

            const html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { fps: 15, qrbox: {width: 250, height: 250} },
                false
            );

            html5QrcodeScanner.render((decodedText) => {
                idInput.value = decodedText;
                html5QrcodeScanner.clear();

                // Visual feedback before submit (Adapted to new color scheme)
                idInput.classList.add('border-[#004d32]', 'bg-green-50');

                setTimeout(() => {
                    document.getElementById('gate-entry-form').submit();
                }, 500);
            });
        }
    </script>
</x-app-layout>
