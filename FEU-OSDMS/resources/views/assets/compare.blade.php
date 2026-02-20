<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.75;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col items-center mb-16 text-center">
                <h1 class="text-7xl font-black text-slate-900 tracking-tighter">Comparison Analysis</h1>
                <div class="flex items-center gap-3 mt-4 px-6 py-2 rounded-full {{ $isMatch ? 'bg-green-50' : 'bg-red-50' }}">
                    <span class="w-3 h-3 {{ $isMatch ? 'bg-green-500' : 'bg-red-600' }} rounded-full animate-pulse"></span>
                    <p class="text-[10px] font-black {{ $isMatch ? 'text-[#004d32]' : 'text-red-600' }} uppercase tracking-[0.4em]">
                        {{ $isMatch ? 'Verification Active' : 'System Alert: Visual Mismatch' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white p-12 rounded-[4rem] shadow-xl border border-slate-100 text-center relative">
                    <span class="absolute top-10 left-10 text-[10px] font-black text-slate-300 uppercase tracking-widest">Database Record</span>
                    <div class="mt-8 rounded-[3rem] overflow-hidden border-[12px] border-slate-50 aspect-square shadow-2xl">
                        <img src="{{ $targetItem->image_url }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                    </div>
                    <h3 class="text-4xl font-black text-slate-900 mt-10 tracking-tighter">{{ $targetItem->item_category }}</h3>
                </div>

                @php $themeColor = $isMatch ? '#004d32' : '#991b1b'; @endphp
                <div class="bg-white p-12 rounded-[4rem] shadow-2xl border-4 text-center relative" style="border-color: {{ $themeColor }}20;">
                    <div class="absolute -top-6 -right-6 text-white p-8 rounded-[3rem] shadow-2xl z-20 w-80 text-left" style="background-color: {{ $themeColor }};">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <span class="block text-[10px] font-black uppercase tracking-widest opacity-60">Similarity</span>
                                <span class="text-5xl font-black tracking-tighter">{{ $similarityScore }}%</span>
                            </div>
                            <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $isMatch ? 'M5 13l4 4L19 7' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' }}"></path></svg>
                            </div>
                        </div>

                        <details class="group border-t border-white/10 pt-5 cursor-pointer" open>
                            <summary class="list-none flex items-center justify-between text-[11px] font-black uppercase tracking-widest opacity-80">
                                Analysis Breakdown
                                <svg class="w-4 h-4 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"></path></svg>
                            </summary>
                            <div class="mt-6 space-y-4">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] font-bold opacity-60 uppercase">Feature Extraction</span>
                                        <span class="text-[11px] font-black">{{ $visualScore }}%</span>
                                    </div>
                                    <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-white h-full transition-all duration-1000" style="width: {{ $visualScore }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </details>
                    </div>

                    <span class="absolute top-10 left-10 text-[10px] font-black text-slate-300 uppercase tracking-widest">Security Capture</span>
                    <div class="mt-8 rounded-[3rem] overflow-hidden border-[12px] border-slate-50 aspect-square shadow-2xl">
                        <img src="{{ asset($comparisonImagePath) }}" class="w-full h-full object-cover">
                    </div>

                    <div class="mt-8 p-6 bg-slate-900 rounded-3xl font-mono text-left border border-slate-800 shadow-inner">
                        <p class="text-[11px] text-green-400 leading-relaxed">
                            <span class="text-green-500/50 uppercase text-[9px] font-bold tracking-widest block mb-1">Vision Processor V2.0</span>
                            <span class="opacity-50">$</span> {{ $breakdown }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-20 flex justify-center gap-8">
                <a href="{{ route('assets.index') }}" class="px-12 py-5 font-black text-slate-400 uppercase text-xs tracking-[0.2em] border-2 border-slate-100 rounded-2xl hover:bg-slate-50 no-underline">Discard Results</a>
                @if ($isMatch)
                    <form action="{{ route('assets.confirm', $targetItem->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background-color: #004d32;" class="px-20 py-5 rounded-[2rem] text-white font-black uppercase text-xs tracking-[0.2em] shadow-2xl shadow-green-900/30 hover:brightness-110 transition-all">Confirm Integrity Match</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
