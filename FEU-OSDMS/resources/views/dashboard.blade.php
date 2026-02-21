<x-app-layout>
    <div class="max-w-7xl mx-auto px-8 lg:px-12 py-12">

        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">Good Afternoon, Admin.</h1>
            <p class="text-xl text-slate-600 mt-3 font-medium">Here is the overview of current operations.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-10 rounded-2xl border-4 border-slate-200 shadow-sm flex flex-col justify-center">
                <span class="text-base font-bold text-slate-500 uppercase tracking-wide">Total Assets</span>
                <p class="text-7xl font-extrabold text-[#004d32] mt-4">{{ $totalAssets }}</p>
            </div>

            <div class="bg-white p-10 rounded-2xl border-4 border-slate-200 shadow-sm flex flex-col justify-center">
                <span class="text-base font-bold text-slate-500 uppercase tracking-wide">Pending Reports</span>
                <p class="text-7xl font-extrabold text-[#004d32] mt-4">{{ $pendingCount }}</p>
            </div>

            <div class="bg-white p-10 rounded-2xl border-4 border-slate-200 shadow-sm flex flex-col justify-center">
                <span class="text-base font-bold text-slate-500 uppercase tracking-wide">Active Violations</span>
                <p class="text-7xl font-extrabold text-[#004d32] mt-4">{{ $activeViolations }}</p>
            </div>
        </div>

        <div class="bg-[#004d32] text-white p-10 lg:p-12 rounded-2xl border-4 border-[#003b26] flex flex-col md:flex-row items-center justify-between gap-10 shadow-lg">
            <div>
                <h2 class="text-3xl font-bold">Smart Scanning is Active</h2>
                <p class="text-green-50 text-lg mt-4 max-w-3xl leading-relaxed font-medium">
                    The system is actively monitoring the database. It automatically reads ID cards and checks physical features of lost items to quickly suggest the rightful owner for you.
                </p>
            </div>
            <a href="{{ route('assets.index') }}" class="bg-[#FECB02] text-[#004d32] px-10 py-5 rounded-xl font-bold text-lg hover:bg-yellow-400 transition-colors shadow-sm whitespace-nowrap border-2 border-transparent">
                View Lost Items
            </a>
        </div>

    </div>
</x-app-layout>
