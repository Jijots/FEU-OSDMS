<x-app-layout>
    <div class="sticky top-0 bg-white border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <a href="{{ route('assets.lost-ids') }}" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </div>
        <div class="text-right">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Dossier View</p>
            <p class="text-xs font-black text-[#004d32] tracking-tighter">ID #{{ $asset->id }}</p>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-100 p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                    <div class="space-y-6">
                        <h1 class="text-6xl font-black text-slate-900 tracking-tighter">ID Card</h1>
                        <div class="rounded-[2.5rem] border-[10px] border-slate-50 overflow-hidden shadow-xl aspect-square bg-slate-50">
                            <img src="{{ $asset->image_url }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        </div>
                    </div>

                    <div class="space-y-12">
                        <div class="p-8 bg-slate-50/50 rounded-[2rem] border border-slate-100">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Log Details</h3>
                            <p class="text-lg font-bold text-slate-600 leading-relaxed mb-6">{{ $asset->description }}</p>
                            <div class="flex gap-4">
                                <span class="px-5 py-2 bg-white rounded-xl border border-slate-200 text-sm font-black text-slate-900">{{ $asset->status }}</span>
                                <span class="px-5 py-2 bg-white rounded-xl border border-slate-200 text-sm font-black text-slate-900">{{ $asset->location_found }}</span>
                            </div>
                        </div>

                        <div class="p-2 space-y-10">
                            <h3 class="text-[10px] font-black text-[#004d32] uppercase tracking-[0.4em]">Semantic AI Match Results</h3>

                            @if($student)
                                <div class="p-8 rounded-[2rem] border-2 border-[#004d32] bg-green-50/20">
                                    <p class="text-[10px] text-[#004d32] font-black mb-4 uppercase tracking-tighter">Identity Verified</p>
                                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter mb-1">{{ $student->name }}</h2>
                                    <p class="text-xl font-black text-[#004d32] tracking-widest">{{ $student->id_number }}</p>

                                    <form action="{{ route('assets.confirm', $asset->id) }}" method="POST" class="mt-8">
                                        @csrf
                                        <button type="submit" class="w-full py-5 rounded-2xl bg-[#004d32] text-white font-black uppercase tracking-[0.2em] text-[10px] shadow-xl hover:brightness-110">
                                            Confirm & Release ID
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="space-y-8">
                                    <div class="p-6 bg-red-50 rounded-2xl border border-red-100">
                                        <p class="text-xs font-bold text-red-900">Drift Detected: No directory match. Manual review required.</p>
                                    </div>

                                    <form action="{{ route('assets.compare', $asset->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Student Full Name</label>
                                                <input type="text" name="manual_name" placeholder="As seen on ID"
                                                    class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-xs focus:ring-1 focus:ring-slate-200" required>
                                            </div>
                                            <div class="space-y-2">
                                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Student ID Number</label>
                                                <input type="text" name="manual_id" placeholder="Ex: 202310790"
                                                    class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-xs focus:ring-1 focus:ring-slate-200" required>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Academic Program</label>
                                            <input type="text" name="manual_program" placeholder="Ex: BSITWMA"
                                                class="w-full px-8 py-5 rounded-2xl bg-slate-50 border-none font-bold text-slate-700 text-xs focus:ring-1 focus:ring-slate-200" required>
                                        </div>

                                        <div class="space-y-4">
                                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Verification Capture</label>
                                            <input type="file" name="compare_image" required
                                                class="w-full text-[10px] text-slate-400 file:mr-6 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-slate-900 file:text-white hover:file:bg-[#004d32] cursor-pointer">
                                        </div>

                                        <button type="submit" class="w-full py-5 rounded-2xl bg-[#004d32] text-white font-black uppercase tracking-[0.2em] text-[10px] shadow-lg">
                                            Execute Multi-Field Scan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
