<x-app-layout>
    <x-slot name="header">New Intelligence Report</x-slot>
    <div class="max-w-2xl mx-auto py-10">
        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100"
              x-data="{ photoPreview: null }">
            @csrf
            <div class="space-y-8">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Item Name</label>
                    <input type="text" name="item_category" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-feu-green font-bold" placeholder="e.g. Hirono King Figure" required>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" rows="4" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-feu-green resize-none" placeholder="Details..." required></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Item Photo</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50 p-6 flex flex-col items-center">
                        <template x-if="photoPreview"><img :src="photoPreview" class="h-48 rounded-xl object-contain mb-4"></template>
                        <input type="file" name="image" class="hidden" x-ref="photo" @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" required>
                        <button type="button" @click="$refs.photo.click()" class="px-6 py-2 bg-white border rounded-xl font-bold">Choose Image</button>
                    </div>
                </div>
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('assets.index') }}" class="flex-1 text-center py-4 font-bold text-gray-400">Cancel</a>
                    <button type="submit" class="flex-[2] py-4 bg-feu-green text-white font-black rounded-2xl shadow-xl">Submit Report</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
