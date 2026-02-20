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
        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" x-data="{ photoPreview: null }" class="space-y-8">
            @csrf

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Report Type</label>
                    <select name="report_type" class="w-full px-8 py-5 rounded-[2rem] bg-slate-50 border-none font-bold text-slate-700 outline-none appearance-none" required>
                        <option value="Found">Found</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Item Category</label>
                    <select name="item_category" class="w-full px-8 py-5 rounded-[2rem] bg-slate-50 border-none font-bold text-slate-700 outline-none appearance-none" required>
                        <option value="Electronics">Electronics</option>
                        <option value="Documents">Documents</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Intelligence Description</label>
                <textarea name="description" rows="5" class="w-full px-8 py-5 rounded-[2.5rem] bg-slate-50 border-none font-bold text-slate-700 outline-none resize-none" placeholder="Provide a detailed description..." required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Location Found/Lost</label>
                    <input type="text" name="location_found" class="w-full px-8 py-5 rounded-[2rem] bg-slate-50 border-none font-bold text-slate-700 outline-none" required>
                </div>
                <div class="flex flex-col">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Options</label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="is_stock_image" value="1" class="w-6 h-6 rounded-lg border-slate-200 text-[#004d32] focus:ring-[#004d32]">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">Is Stock Image</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Security Capture</label>
                <div class="border-4 border-dashed border-slate-100 rounded-[2.5rem] p-10 text-center hover:border-[#004d32] transition-colors group bg-slate-50">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="h-48 mx-auto rounded-2xl object-cover mb-6 shadow-2xl border-4 border-white">
                    </template>
                    <input type="file" name="image" class="hidden" x-ref="photo" @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" required>
                    <button type="button" @click="$refs.photo.click()" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest group-hover:bg-[#004d32] transition-all">Select Image</button>
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <a href="{{ route('assets.index') }}" class="flex-1 text-center py-5 font-black text-slate-300 uppercase text-xs no-underline hover:text-slate-500 transition-colors">Cancel</a>
                <button type="submit" class="flex-[2] py-5 bg-[#004d32] text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-2xl hover:brightness-110 transition-all">Finalize Log Entry</button>
            </div>
        </form>
    </div>
</x-app-layout>
