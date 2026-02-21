<x-app-layout>
    <div class="max-w-4xl mx-auto px-8 py-10">

        <div class="mb-10 flex items-center justify-between border-b-2 border-slate-100 pb-6">
            <div>
                <a href="{{ route('assets.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Registry
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Log New Asset Record</h1>
            </div>
            <span class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm border-2 border-slate-200">New Entry</span>
        </div>

        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" x-data="{ photoPreview: null }" class="space-y-8 bg-white border-2 border-slate-200 rounded-2xl p-10 shadow-sm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Report Type</label>
                    <select name="report_type" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0">
                        <option value="Lost">Missing Item Report</option>
                        <option value="Found">Found Item Report</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Item Category</label>
                    <select name="item_category" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0">
                        <option>Electronics</option>
                        <option>ID / Identification</option>
                        <option>Bags / Backpacks</option>
                        <option>Clothing / Apparel</option>
                        <option>Books / Documents</option>
                        <option>Keys / Accessories</option>
                        <option>Others</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Location Involved</label>
                    <input type="text" name="location" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0" placeholder="e.g. T404, Tech Building Lobby">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Date Involved</label>
                    <input type="date" name="date" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Detailed Description</label>
                <textarea name="description" rows="4" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-base font-medium text-slate-800 focus:border-[#004d32] focus:ring-0 placeholder:font-normal" placeholder="Provide distinct characteristics like color, brand, or unique markings..."></textarea>
            </div>

            <div class="border-t-2 border-slate-100 pt-8">
                <label class="block text-sm font-bold text-slate-700 mb-4">Item Photograph (Required)</label>
                <div class="border-4 border-dashed border-slate-200 rounded-2xl p-10 text-center hover:border-[#004d32] transition-colors group bg-slate-50 cursor-pointer" @click="$refs.photo.click()">

                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="h-48 mx-auto rounded-xl object-contain mb-6 border-4 border-white shadow-sm bg-white p-2">
                    </template>
                    <template x-if="!photoPreview">
                        <svg class="w-12 h-12 mx-auto text-slate-400 mb-4 group-hover:text-[#004d32] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </template>

                    <input type="file" name="image" class="hidden" x-ref="photo" @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" required>
                    <span class="block text-sm font-bold text-slate-600 group-hover:text-[#004d32] transition-colors" x-text="photoPreview ? 'Click to change image' : 'Select Image File'"></span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-2 border-slate-100">
                <a href="{{ route('assets.index') }}" class="w-full sm:w-auto px-8 py-4 text-center text-base font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="w-full py-4 bg-[#004d32] text-white text-base font-bold rounded-xl hover:bg-green-800 transition-colors shadow-sm text-center flex-1">
                    Save Record to Vault
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
