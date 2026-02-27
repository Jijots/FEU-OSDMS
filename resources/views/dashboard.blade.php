<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-7xl mx-auto px-8 lg:px-12 py-12">

        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">Good Afternoon, Admin.</h1>
            <p class="text-xl text-slate-600 mt-3 font-medium">Here is the overview of current operations for {{ $sy }} • {{ $semester }}.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

            <a href="{{ route('assets.index') }}" class="group bg-white p-10 rounded-2xl border-4 border-slate-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:border-[#004d32] hover:shadow-xl hover:-translate-y-1 active:scale-95">
                <span class="text-base font-bold text-slate-500 uppercase tracking-wide group-hover:text-[#004d32] transition-colors">Total Assets</span>
                <p class="text-7xl font-extrabold text-[#004d32] mt-4">{{ $totalAssets }}</p>
            </a>

            <a href="{{ route('incidents.index', ['status' => 'Pending Review']) }}" class="group bg-white p-10 rounded-2xl border-4 border-slate-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:border-indigo-500 hover:shadow-xl hover:-translate-y-1 active:scale-95">
                <span class="text-base font-bold text-slate-500 uppercase tracking-wide group-hover:text-indigo-600 transition-colors">Pending Reports</span>
                <p class="text-7xl font-extrabold text-[#004d32] mt-4 group-hover:text-indigo-600 transition-colors">{{ $pendingCount }}</p>
            </a>

            <a href="{{ route('violations.report', ['status' => 'Active']) }}" class="group bg-white p-10 rounded-2xl border-4 border-slate-200 shadow-sm flex flex-col justify-center transition-all duration-300 hover:border-red-500 hover:shadow-xl hover:-translate-y-1 active:scale-95">
                <span class="text-base font-bold text-slate-500 uppercase tracking-wide group-hover:text-red-600 transition-colors">Active Violations</span>
                <p class="text-7xl font-extrabold text-[#004d32] mt-4 group-hover:text-red-600 transition-colors">{{ $activeViolations }}</p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            <div class="bg-white border-4 border-slate-200 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Recovery Hotspots</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Found Item Distribution</p>
                    </div>
                    <a href="{{ route('reports.hotspots', ['type' => 'assets']) }}" class="group flex items-center gap-2 px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Export</span>
                    </a>
                </div>

                <div class="relative h-[300px]">
                    @if($assetHotspots->count() > 0)
                        <canvas id="assetChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-50 rounded-xl border-2 border-dashed border-slate-200">
                            <p class="text-sm font-bold text-slate-400 uppercase">Insufficient Data for Mapping</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white border-4 border-slate-200 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Incident Hotspots</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Security Activity Levels</p>
                    </div>
                    <a href="{{ route('reports.hotspots', ['type' => 'incidents']) }}" class="group flex items-center gap-2 px-3 py-2 bg-red-50 text-red-700 rounded-lg border border-red-100 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Export</span>
                    </a>
                </div>

                <div class="relative h-[300px]">
                    @if($incidentHotspots->count() > 0)
                        <canvas id="incidentChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-50 rounded-xl border-2 border-dashed border-slate-200">
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No Incident Data Recorded</p>
                        </div>
                    @endif
                </div>
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

    @if($assetHotspots->count() > 0 || $incidentHotspots->count() > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Asset Recovery Chart (Doughnut)
            const assetCtx = document.getElementById('assetChart');
            if(assetCtx) {
                new Chart(assetCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($assetHotspots->pluck('location_found')) !!},
                        datasets: [{
                            data: {!! json_encode($assetHotspots->pluck('total')) !!},
                            backgroundColor: ['#4f46e5', '#818cf8', '#c7d2fe'],
                            hoverBackgroundColor: '#312e81',
                            borderWidth: 5,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 20, font: { family: 'Inter', weight: 'bold', size: 12 } }
                            }
                        }
                    }
                });
            }

            // 2. Incident Activity Chart (Bar)
            const incidentCtx = document.getElementById('incidentChart');
            if(incidentCtx) {
                new Chart(incidentCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($incidentHotspots->pluck('incident_location')) !!},
                        datasets: [{
                            label: 'Reported Cases',
                            data: {!! json_encode($incidentHotspots->pluck('total')) !!},
                            backgroundColor: '#ef4444',
                            borderRadius: 12,
                            barThickness: 45
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { weight: 'bold' } },
                                grid: { color: '#f1f5f9' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { weight: 'bold' } }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endif
</x-app-layout>
