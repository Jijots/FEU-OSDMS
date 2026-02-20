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
        <h2 class="text-[10px] font-black text-slate-400 tracking-widest uppercase">New Intelligence Report</h2>
    </div>

    <div class="max-w-2xl mx-auto py-16">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <ul class="list-disc ml-5 text-sm font-bold">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-slate-100" x-data="{ photoPreview: null }">
            @csrf
            <div class="space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <label class="cursor-pointer group">
                        <input type="radio" name="report_type" value="Lost" class="peer hidden" checked>
                        <div class="p-6 border-2 border-slate-100 rounded-3xl peer-checked:border-[#004d32] peer-checked:bg-green-50 text-center transition-all group-hover:bg-slate-50">
                            <span class="block font-black text-slate-900">I Lost an Item</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="report_type" value="Found" class="peer hidden">
                        <div class="p-6 border-2 border-slate-100 rounded-3xl peer-checked:border-[#004d32] peer-checked:bg-green-50 text-center transition-all group-hover:bg-slate-50">
                            <span class="block font-black text-slate-900">I Found an Item</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Item Information</label>
                    <input type="text" name="item_category" placeholder="Item Name" class="w-full px-8 py-5 rounded-2xl border-slate-100 bg-slate-50 font-bold focus:ring-[#004d32]" required>
                    <input type="date" name="date_lost" class="w-full px-8 py-5 rounded-2xl border-slate-100 bg-slate-50 font-bold mt-4 focus:ring-[#004d32]" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Description</label>
                    <textarea name="description" rows="3" class="w-full px-8 py-5 rounded-2xl border-slate-100 bg-slate-50 resize-none font-medium" required></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Security Capture</label>
                    <div class="border-4 border-dashed border-slate-100 rounded-[2.5rem] p-10 text-center hover:border-[#004d32] transition-colors">
                        <template x-if="photoPreview"><img :src="photoPreview" class="h-48 mx-auto rounded-2xl object-contain mb-6 shadow-2xl"></template>
                        <input type="file" name="image" class="hidden" x-ref="photo" @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" required>
                        <button type="button" @click="$refs.photo.click()" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest">Select Image</button>
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <a href="{{ route('assets.index') }}" class="flex-1 text-center py-5 font-black text-slate-300 uppercase text-xs no-underline">Cancel</a>
                    <button type="submit" class="flex-[2] py-5 bg-[#004d32] text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-2xl shadow-green-900/20 hover:brightness-110 transition-all">Submit Intelligence Report</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
