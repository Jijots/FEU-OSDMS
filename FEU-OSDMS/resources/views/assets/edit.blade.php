<x-app-layout>
    <div
        class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>

        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System
                    Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
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
    <x-slot name="header">Edit Intelligence Report</x-slot>
    <div class="max-w-2xl mx-auto py-10">
        <form action="{{ route('assets.update', $item->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100" x-data="{ photoPreview: null }">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Item
                            Name</label>
                        <input type="text" name="item_category" value="{{ $item->item_category }}"
                            class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Date
                            Lost</label>
                        <input type="date" name="date_lost" value="{{ $item->date_lost }}"
                            class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Current
                        Status</label>
                    <select name="status" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold">
                        <option value="Lost" {{ $item->status === 'Lost' ? 'selected' : '' }}>Lost</option>
                        <option value="Claimed" {{ $item->status === 'Claimed' ? 'selected' : '' }}>Claimed</option>
                    </select>
                </div>

                <div
                    class="flex items-center gap-3 p-5 bg-blue-50/50 rounded-2xl border border-blue-100 transition-all hover:bg-blue-50">
                    <input type="checkbox" name="is_stock_image" id="is_stock_image"
                        class="w-5 h-5 rounded text-feu-green" value="1"
                        {{ $item->is_stock_image ? 'checked' : '' }}>
                    <label for="is_stock_image" class="cursor-pointer select-none">
                        <span class="block text-sm font-black text-blue-900">This is a Web-Downloaded / Stock
                            Image</span>
                        <span class="block text-xs font-medium text-blue-600 mt-0.5">Check this if the image is from the
                            internet and not a real photo.</span>
                    </label>
                </div>

                <div>
                    <label
                        class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" rows="3" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 resize-none"
                        required>{{ $item->description }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Update Photo
                        (Optional)</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-3xl p-6 text-center">
                        <template x-if="photoPreview"><img :src="photoPreview"
                                class="h-48 mx-auto rounded-xl object-contain mb-4"></template>
                        <input type="file" name="image" class="hidden" x-ref="photo"
                            @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);">
                        <button type="button" @click="$refs.photo.click()"
                            class="bg-white border px-4 py-2 rounded-lg font-bold">Replace Image</button>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('assets.index') }}"
                        class="flex-1 text-center py-4 font-bold text-gray-400">Cancel</a>
                    <button type="submit" class="flex-[2] py-4 bg-feu-green text-white font-black rounded-2xl">Save
                        Changes</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
