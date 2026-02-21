<x-app-layout>
    <div class="py-12 bg-[#F8FAFB]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="mb-14">
                <h1 class="text-6xl lg:text-7xl font-black text-slate-900 tracking-tighter leading-tight mb-2">Good Afternoon, OSD!</h1>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ $sy }} | {{ $semester }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-[#004d32] p-8 rounded-2xl shadow-sm border border-[#003a26] text-white transition-transform hover:-translate-y-1">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Total Asset Logs</span>
                    <div class="text-7xl font-black mt-2 tracking-tighter leading-none">{{ $totalAssets }}</div>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center transition-transform hover:-translate-y-1">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pending Reports</span>
                    <div class="text-7xl font-black text-[#004d32] mt-2 tracking-tighter">{{ $pendingCount }}</div>
                </div>

                <div class="bg-[#FECB02] p-8 rounded-2xl shadow-sm border border-[#e5b600] text-[#004d32] text-center transition-transform hover:-translate-y-1">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Active Violations</span>
                    <div class="text-7xl font-black mt-2 tracking-tighter">{{ $activeViolations }}</div>
                </div>
            </div>

            <div class="bg-white p-10 lg:p-12 rounded-2xl border border-slate-100 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">IntelliThings Live Status</span>

                    <div class="flex flex-wrap gap-3 mt-6">
                        <span class="px-5 py-2.5 bg-blue-50 border border-blue-100 text-blue-700 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm">
                            {{ $activeCount }} Active
                        </span>
                        <span class="px-5 py-2.5 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm">
                            {{ $matchedCount }} Matched
                        </span>
                        <span class="px-5 py-2.5 bg-green-50 border border-green-100 text-green-700 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm">
                            {{ $claimedCount }} Claimed
                        </span>
                    </div>
                </div>

                <a href="{{ route('assets.index') }}" class="px-10 py-5 bg-[#004d32] text-white rounded-xl font-black uppercase tracking-[0.2em] text-xs shadow-md hover:brightness-110 hover:-translate-y-1 active:scale-95 transition-all text-center no-underline">
                    Open Complete Logs
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
