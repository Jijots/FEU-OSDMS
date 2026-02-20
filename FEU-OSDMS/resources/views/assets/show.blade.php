<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>

        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-100 p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest">Record #{{ $item->id }}</span>
                        </div>
                        <h1 class="text-6xl font-black text-slate-900 tracking-tighter">{{ $item->item_category }}</h1>
                        <div class="rounded-[2.5rem] border-[10px] border-slate-50 overflow-hidden shadow-xl aspect-square">
                            <img src="{{ $item->image_url }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Report Details</h3>
                            <div class="text-sm font-medium text-slate-500 space-y-2">
                                <p><strong class="text-slate-900">Type:</strong> {{ $item->report_type }}</p>
                                <p><strong class="text-slate-900">Description:</strong> {{ $item->description }}</p>
                            </div>
                        </div>

                        <form action="{{ route('assets.compare', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Input Security Capture</label>
                                <input type="file" name="compare_image" required class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                            </div>

                            <button type="submit" style="background-color: #004d32;" class="w-full py-5 rounded-2xl text-white font-black uppercase tracking-widest text-xs shadow-lg hover:brightness-110 transition-all">
                                Execute Comparison
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
