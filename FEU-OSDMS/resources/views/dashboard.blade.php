<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <div class="mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Good Afternoon, OSD.</h2>
            <p class="text-slate-500 font-medium">Overview of the current academic term operations.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Assets</span>
                <p class="text-5xl font-extrabold text-[#004d32] mt-1">{{ $totalAssets }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pending Reports</span>
                <p class="text-5xl font-extrabold text-[#004d32] mt-1">{{ $pendingCount }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Violations</span>
                <p class="text-5xl font-extrabold text-[#004d32] mt-1">{{ $activeViolations }}</p>
            </div>
        </div>

        <div class="bg-[#004d32] text-white p-8 rounded-xl flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold">IntelliThings Visual Matching</h3>
                <p class="text-white/70 text-sm mt-1">AI resolution is active for the current lost items database.</p>
            </div>
            <a href="{{ route('assets.index') }}" class="bg-[#FECB02] text-[#004d32] px-6 py-3 rounded-lg font-bold text-sm hover:brightness-105 transition-all">
                View Asset Records
            </a>
        </div>
    </div>
</x-app-layout>
