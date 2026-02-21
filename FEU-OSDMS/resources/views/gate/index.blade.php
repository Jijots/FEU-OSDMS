<x-app-layout>
    <div class="py-12 px-12 max-w-7xl mx-auto">

        @if(session('warning'))
            <div class="mb-12 p-6 bg-red-50 border-2 border-red-200 rounded-[2rem] flex items-center gap-4 shadow-sm animate-pulse">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <p class="text-sm font-black text-red-700 tracking-tight uppercase">SYSTEM ALERT: {{ session('warning') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">

            <div class="lg:col-span-4 lg:sticky lg:top-32">
                <div class="mb-10">
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter leading-none">Scanner.</h1>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-3">Live Security Checkpoint</p>
                </div>

                <button type="button" id="start-scanner-btn" onclick="startScanner()" class="w-full py-5 mb-6 bg-[#004d32] text-[#FECB02] rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-xl hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    Enable Camera Scanner
                </button>

                <div id="scanner-container" class="hidden mb-8">
                    <div id="reader" class="rounded-[2rem] overflow-hidden border-8 border-white shadow-2xl bg-slate-50"></div>
                </div>

                <form id="gate-entry-form" action="{{ route('gate.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 block">Student Identifier</label>
                        <input type="text" id="id_number_input" name="id_number" placeholder="SCAN OR TYPE UID..."
                               class="w-full px-8 py-5 bg-white border border-slate-100 rounded-2xl font-mono text-xl font-black text-slate-900 focus:ring-4 focus:ring-[#FECB02]/20 focus:border-[#FECB02] shadow-sm transition-all" required>
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 block">Entry Classification</label>
                        <select name="reason" class="w-full px-8 py-5 bg-white border border-slate-100 rounded-2xl font-black text-xs text-slate-700 focus:ring-4 focus:ring-[#FECB02]/20 focus:border-[#FECB02] shadow-sm appearance-none transition-all uppercase tracking-widest">
                            <option value="Forgot ID">Forgot ID</option>
                            <option value="Lost ID">Lost ID</option>
                            <option value="Visitor">Visitor</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#FECB02] text-[#004d32] rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-lg hover:brightness-105 active:scale-95 transition-all mt-4">
                        Authorize Entry
                    </button>
                </form>
            </div>

            <div class="lg:col-span-8">
                <div class="flex items-center justify-between mb-10 pb-6 border-b border-slate-100">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Active Logs</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Real-time Feed</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($entries as $entry)
                        <div class="flex items-center justify-between p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm group hover:shadow-md transition-all">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center font-black text-[#004d32] border border-slate-100">
                                    {{ substr($entry->student->name ?? 'V', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-900 text-xl tracking-tight leading-none">{{ $entry->student->name ?? 'Visitor' }}</p>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">UID: {{ $entry->student->id_number ?? 'TEMPORARY-ACCESS' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-10">
                                <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest {{ $entry->reason === 'Forgot ID' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                    {{ $entry->reason }}
                                </span>

                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <a href="{{ route('gate.edit', $entry->id) }}" class="p-3 text-slate-300 hover:text-[#004d32] hover:bg-slate-50 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('gate.destroy', $entry->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-3 text-slate-300 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-32 text-center">
                            <p class="text-[11px] font-black text-slate-300 uppercase tracking-[0.5em]">Terminal Status: Idle</p>
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

                // Visual feedback before submit
                idInput.classList.add('ring-4', 'ring-green-500');

                setTimeout(() => {
                    document.getElementById('gate-entry-form').submit();
                }, 500);
            });
        }
    </script>
</x-app-layout>
