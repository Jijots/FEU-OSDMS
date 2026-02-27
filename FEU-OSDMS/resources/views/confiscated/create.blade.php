<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('confiscated-items.index') }}"
                    class="text-slate-400 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                    <svg class="w-8 h-8 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    Log Confiscated Contraband
                </h1>
            </div>
            <p class="text-sm text-slate-500 font-bold uppercase tracking-widest ml-9">Evidence Locker / Initial Seizure Report</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
            <div class="bg-red-50 border-b border-red-100 px-8 py-4">
                <p class="text-xs font-bold text-red-800 uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Officer on Duty: {{ Auth::user()->name }}
                </p>
            </div>

            <form action="{{ route('confiscated-items.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="col-span-1 md:col-span-2">
                        <label for="item_name" class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Item / Contraband Name <span class="text-red-500">*</span></label>
                        <input type="text" name="item_name" id="item_name" required placeholder="e.g., Unregistered Vape, Confiscated Fake ID"
                            class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-medium transition-colors"
                            value="{{ old('item_name') }}">
                        @error('item_name')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Photographic Evidence</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="photo" id="photo-label" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-red-50 transition-colors">

                                <div id="photo-text-container" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-slate-500"><span class="font-bold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-slate-400 font-medium">PNG, JPG, JPEG or WEBP (MAX. 4MB)</p>
                                </div>

                                <input id="photo" name="photo" type="file" class="hidden" accept="image/*" onchange="updatePhotoUI(this)" />
                            </label>
                        </div>
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="student_id" class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Taken From (Student ID)</label>
                        <input type="text" name="student_id" id="student_id" placeholder="e.g., 202312345"
                            class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-mono font-bold transition-colors"
                            value="{{ old('student_id') }}">
                        <p class="text-xs text-slate-400 mt-2 font-medium">Leave blank if the owner is unknown or fled.</p>
                        @error('student_id')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="storage_location" class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Storage Vault / Location</label>
                        <input type="text" name="storage_location" id="storage_location" placeholder="e.g., Locker A, Drawer 3"
                            class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-medium transition-colors"
                            value="{{ old('storage_location') }}">
                        @error('storage_location')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-extrabold text-slate-700 mb-2 uppercase tracking-wide">Physical Description & Condition</label>
                        <textarea name="description" id="description" rows="3" placeholder="Describe the item in detail (brand, color, serial number if applicable, identifying marks...)"
                            class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-medium transition-colors">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('confiscated-items.index') }}" class="px-6 py-3 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all border-2 border-transparent">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-red-800 text-white font-bold rounded-xl shadow-lg hover:bg-red-900 transition-all flex items-center gap-2 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Secure in Locker
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updatePhotoUI(input) {
            const container = document.getElementById('photo-text-container');
            const label = document.getElementById('photo-label');

            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;

                // Change the box to green to indicate success
                label.classList.remove('bg-slate-50', 'border-slate-300', 'border-dashed');
                label.classList.add('bg-green-50', 'border-green-400', 'border-solid');

                // Show the filename and a checkmark
                container.innerHTML = `
                    <svg class="w-8 h-8 mb-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="mb-2 text-sm text-green-800 font-bold">Image Attached Successfully</p>
                    <p class="text-xs text-green-600 font-mono truncate max-w-[250px]">${fileName}</p>
                `;
            }
        }
    </script>
</x-app-layout>
