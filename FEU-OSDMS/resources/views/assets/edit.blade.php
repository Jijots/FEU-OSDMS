<x-app-layout>
    <x-slot name="header">Edit Item Details</x-slot>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        <form action="{{ route('assets.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Item Name</label>
                <input type="text" name="item_category" value="{{ $item->item_category }}" class="w-full rounded-xl border-gray-300 focus:border-feu-green focus:ring-feu-green" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-xl border-gray-300 focus:border-feu-green focus:ring-feu-green" required>{{ $item->description }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Update Image (Optional)</label>
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-feu-green file:text-white hover:file:bg-feu-green-dark">
            </div>
            <div class="flex gap-4">
                <a href="{{ route('assets.index') }}" class="flex-1 text-center py-3 border border-gray-300 rounded-xl font-bold text-gray-700">Cancel</a>
                <button type="submit" class="flex-1 py-3 bg-feu-green text-white font-bold rounded-xl shadow-md">Update Details</button>
            </div>
        </form>
    </div>
</x-app-layout>
