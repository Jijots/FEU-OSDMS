<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto py-10">
        <form action="{{ route('assets.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100">
            @csrf @method('PUT')

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Item Name</label>
                        <input type="text" name="item_category" value="{{ $item->item_category }}" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Date Lost</label>
                        <input type="date" name="date_lost" value="{{ $item->date_lost->format('Y-m-d') }}" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Current Status</label>
                    <select name="status" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 font-bold">
                        <option value="Lost" {{ $item->status === 'Lost' ? 'selected' : '' }}>Lost</option>
                        <option value="Claimed" {{ $item->status === 'Claimed' ? 'selected' : '' }}>Claimed</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 p-5 bg-blue-50/50 rounded-2xl border border-blue-100 transition-all hover:bg-blue-50">
                    <input type="checkbox" name="is_stock_image" id="is_stock_image" class="w-5 h-5 rounded text-[#004d32]" value="1" {{ $item->is_stock_image ? 'checked' : '' }}>
                    <label for="is_stock_image" class="cursor-pointer select-none">
                        <span class="block text-sm font-black text-blue-900">This is a Web-Downloaded / Stock Image</span>
                        <span class="block text-xs font-medium text-blue-600 mt-0.5">Check this if the image is from the internet and not a real photo.</span>
                    </label>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" rows="3" class="w-full px-6 py-4 rounded-2xl border-gray-200 bg-gray-50 resize-none" required>{{ $item->description }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Update Photo (Optional)</label>

                    <input type="file" id="image-upload" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer mb-4">

                    <div id="initial-preview" class="border-2 border-dashed border-gray-200 rounded-3xl p-6 text-center">
                        <img src="{{ $item->image_url }}" class="h-48 mx-auto rounded-xl object-contain shadow-sm opacity-50">
                    </div>

                    <div id="cropper-wrapper" style="display: none;" class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <div style="max-height: 400px; width: 100%; overflow: hidden;" class="rounded-xl border border-slate-200 bg-black">
                            <img id="cropper-image" style="display: block; max-width: 100%;">
                        </div>
                        <button type="button" id="crop-button" class="w-full py-3 mt-4 rounded-xl bg-slate-800 text-white font-black uppercase tracking-[0.2em] text-[10px] hover:bg-slate-900 transition-colors">
                            Confirm Free Crop
                        </button>
                    </div>

                    <div id="preview-wrapper" style="display: none;" class="mt-4 text-center border-2 border-dashed border-gray-200 rounded-3xl p-6">
                        <p class="text-[9px] font-black text-green-600 uppercase mb-4 tracking-widest">New Image Ready</p>
                        <img id="cropped-preview" class="mx-auto rounded-xl border-4 border-white max-h-48 max-w-full object-contain shadow-xl">
                        <input type="hidden" name="cropped_image" id="cropped_image_input">
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('assets.index') }}" class="flex-1 text-center py-4 font-bold text-gray-400">Cancel</a>
                    <button type="submit" id="submit-btn" class="flex-[2] py-4 bg-[#004d32] text-white font-black rounded-2xl">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cropper = null;
            const uploadInput = document.getElementById('image-upload');
            const initialPreview = document.getElementById('initial-preview');
            const cropperWrapper = document.getElementById('cropper-wrapper');
            const previewWrapper = document.getElementById('preview-wrapper');
            const cropperImage = document.getElementById('cropper-image');
            const croppedPreview = document.getElementById('cropped-preview');
            const hiddenInput = document.getElementById('cropped_image_input');
            const cropButton = document.getElementById('crop-button');
            const submitBtn = document.getElementById('submit-btn');

            uploadInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                initialPreview.style.display = 'none';
                cropperWrapper.style.display = 'block';
                previewWrapper.style.display = 'none';

                // Disable save until crop is confirmed
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    if (cropper) { cropper.destroy(); }
                    cropper = new Cropper(cropperImage, {
                        viewMode: 1, autoCropArea: 0.9, responsive: true,
                        guides: true, center: true, highlight: false,
                        background: false, cropBoxMovable: true, cropBoxResizable: true,
                    });
                };
                reader.readAsDataURL(file);
            });

            cropButton.addEventListener('click', function() {
                if (!cropper) return;
                const canvas = cropper.getCroppedCanvas({
                    maxWidth: 1024, maxHeight: 1024,
                    imageSmoothingEnabled: true, imageSmoothingQuality: 'high',
                });

                // Base64 JPEG
                const base64 = canvas.toDataURL('image/jpeg', 0.95);
                hiddenInput.value = base64;
                croppedPreview.src = base64;

                cropperWrapper.style.display = 'none';
                previewWrapper.style.display = 'block';

                // Re-enable save
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        });
    </script>
</x-app-layout>
