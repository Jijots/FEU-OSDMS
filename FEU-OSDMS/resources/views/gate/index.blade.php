<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </div>
        <div class="text-right">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">
                {{ str_contains(auth()->user()->email ?? '', 'admin') ? 'System Terminal' : 'Checkpoint Terminal' }}
            </p>
            <p class="text-xs font-black text-[#004d32] tracking-tighter">
                {{ str_contains(auth()->user()->email ?? '', 'admin') ? 'ADMIN' : 'GUARD' }}-{{ auth()->id() }}
            </p>
        </div>
    </div>

    <div class="py-12 bg-[#F8FAFB]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('warning'))
                <div class="mb-8 p-6 bg-red-50 border-2 border-red-200 rounded-2xl flex items-center gap-4 shadow-sm animate-pulse">
                    <p class="text-sm font-black text-red-700 tracking-tight">ALERT: {{ session('warning') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start mt-8">

                <div class="lg:col-span-4 lg:sticky lg:top-32">
                    <div class="mb-10">
                        <h2 class="text-4xl font-black text-slate-900 tracking-tighter mb-1">Gate Scanner</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Manual or QR Identification</p>
                    </div>

                    <button type="button" id="start-scanner-btn" onclick="startScanner()" class="w-full py-4 mb-6 bg-[#004d32] text-[#FECB02] rounded-xl font-black uppercase tracking-[0.2em] text-xs shadow-md hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke="currentColor" /></svg>
                        Enable Camera Scanner
                    </button>

                    <div id="scanner-container" class="hidden mb-6">
                        <div id="reader" class="rounded-2xl overflow-hidden border-4 border-slate-100 shadow-inner bg-slate-50"></div>
                    </div>

                    <form id="gate-entry-form" action="{{ route('gate.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="text" id="id_number_input" name="id_number" placeholder="Scan Student UID..."
                               class="w-full px-6 py-4 bg-white border-none rounded-xl font-mono text-xl font-bold text-slate-900 focus:ring-2 focus:ring-[#FECB02] shadow-sm" required>

                        <select name="reason" class="w-full px-6 py-4 bg-white border-none rounded-xl font-bold text-sm text-slate-700 focus:ring-2 focus:ring-[#FECB02] shadow-sm">
                            <option value="Forgot ID">Forgot ID</option>
                            <option value="Lost ID">Lost ID</option>
                            <option value="Visitor">Visitor</option>
                        </select>

                        <button type="submit" class="w-full py-4 bg-[#FECB02] text-[#004d32] rounded-xl font-black uppercase tracking-[0.2em] text-xs shadow-md hover:brightness-110 active:scale-95 transition-all">
                            Grant Access
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-slate-100 p-10">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8 border-b border-slate-50 pb-6">Today's Active Log</h3>

                    <div class="space-y-3">
                        @forelse($entries as $entry)
                            <div class="flex items-center justify-between p-4 rounded-xl group hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-[#F8FAFB] rounded-full flex items-center justify-center font-black text-slate-400 border border-slate-100">
                                        {{ substr($entry->student->name ?? 'V', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 text-lg">{{ $entry->student->name ?? 'Visitor' }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">UID: {{ $entry->student->id_number ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-8">
                                    <span class="px-3 py-1.5 rounded-md text-[9px] font-black uppercase tracking-widest {{ $entry->reason === 'Forgot ID' ? 'bg-orange-50 text-orange-600' : 'bg-blue-50 text-blue-600' }}">
                                        {{ $entry->reason }}
                                    </span>

                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('gate.edit', $entry->id) }}" class="p-2 text-slate-300 hover:text-[#004d32]"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2.5" /></svg></a>
                                        <form action="{{ route('gate.destroy', $entry->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-300 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5" /></svg></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="py-20 text-center text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">Terminal Idle</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function startScanner() {
            const scannerContainer = document.getElementById('scanner-container');
            const idInput = document.getElementById('id_number_input');
            scannerContainer.classList.remove('hidden');
            const html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 }, false);
            html5QrcodeScanner.render((decodedText) => {
                idInput.value = decodedText;
                html5QrcodeScanner.clear();
                document.getElementById('gate-entry-form').submit();
            });
        }
    </script>
</x-app-layout>
