<x-app-layout>
    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
    <div class="flex items-center gap-10">
        <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
            <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
        <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
    </div>

    <div class="flex items-center gap-6">
        <div class="text-right">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] leading-none mb-1">System
                Terminal</p>
            <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
        </div>
        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
    </div>
</div>
    <x-slot name="header">New Intelligence Report</x-slot>
    <div class="max-w-2xl mx-auto py-10">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <ul class="list-disc ml-5 text-sm font-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100" x-data="{ photoPreview: null }">
            @csrf
            <div class="space-y-6">

                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="report_type" value="Lost" class="peer hidden" checked>
                        <div
                            class="p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-feu-green peer-checked:bg-green-50 text-center transition-all">
                            <span class="block font-black text-gray-900">I Lost an Item</span>
                            <span class="text-xs text-gray-500 font-medium">Add to search pool</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="report_type" value="Found" class="peer hidden">
                        <div
                            class="p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-feu-green peer-checked:bg-green-50 text-center transition-all">
                            <span class="block font-black text-gray-900">I Found an Item</span>
                            <span class="text-xs text-gray-500 font-medium">Initiate AI Matching</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Item
                        Name</label>
                    <input type="text" name="item_category"
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold" required>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Date Lost /
                        Found</label>
                    <input type="date" name="date_lost"
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold" required>
                </div>
                <div>
                    <label
                        class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" rows="3" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 resize-none"
                        required></textarea>
                </div>

                <div
                    class="flex items-center gap-3 p-5 bg-blue-50/50 rounded-2xl border border-blue-100 transition-all hover:bg-blue-50">
                    <input type="checkbox" name="is_stock_image" id="is_stock_image"
                        class="w-5 h-5 rounded text-feu-green focus:ring-feu-green" value="1">
                    <label for="is_stock_image" class="cursor-pointer select-none">
                        <span class="block text-sm font-black text-blue-900">This is a Web-Downloaded / Stock
                            Image</span>
                        <span class="block text-xs font-medium text-blue-600 mt-0.5">Applies Color-Correlation
                            verification to bypass background noise</span>
                    </label>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Item
                        Photo</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-3xl p-6 text-center">
                        <template x-if="photoPreview"><img :src="photoPreview"
                                class="h-48 mx-auto rounded-xl object-contain mb-4"></template>
                        <input type="file" name="image" class="hidden" x-ref="photo"
                            @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);"
                            required>
                        <button type="button" @click="$refs.photo.click()"
                            class="bg-white border px-4 py-2 rounded-lg font-bold">Choose Image</button>
                    </div>
                </div>
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('assets.index') }}"
                        class="flex-1 text-center py-4 font-bold text-gray-400">Cancel</a>
                    <button type="submit" class="flex-[2] py-4 bg-feu-green text-white font-black rounded-2xl">Submit
                        Report</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>


