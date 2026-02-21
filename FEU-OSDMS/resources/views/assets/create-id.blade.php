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
        <h2 class="text-[10px] font-black text-slate-400 tracking-widest uppercase">New Intelligence Report</h2>
    </div>

    <div class="max-w-2xl mx-auto py-16">
        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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

                <input type="file" id="image-upload" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer mb-4">

                <div id="cropper-wrapper" style="display: none;" class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                    <div style="max-height: 400px; width: 100%; overflow: hidden;" class="rounded-xl border border-slate-200 bg-black">
                        <img id="cropper-image" style="display: block; max-width: 100%;">
                    </div>
                    <button type="button" id="crop-button" class="w-full py-3 mt-4 rounded-xl bg-slate-800 text-white font-black uppercase tracking-[0.2em] text-[10px] hover:bg-slate-900 transition-colors">
                        Confirm Free Crop
                    </button>
                </div>

                <div id="preview-wrapper" style="display: none;" class="text-center bg-slate-50 p-6 rounded-[2.5rem] border border-slate-100">
                    <p class="text-[9px] font-black text-green-600 uppercase mb-4 tracking-widest">Database Image Ready</p>
                    <img id="cropped-preview" class="mx-auto rounded-xl border-4 border-white max-h-64 max-w-full object-contain shadow-xl">
                    <input type="hidden" name="cropped_image" id="cropped_image_input">
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <a href="{{ route('assets.index') }}" class="flex-1 text-center py-5 font-black text-slate-300 uppercase text-xs no-underline hover:text-slate-500 transition-colors">Cancel</a>
                <button type="submit" id="submit-btn" class="flex-[2] py-5 bg-[#004d32] text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-2xl transition-all opacity-50 cursor-not-allowed" disabled>Finalize Log Entry</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cropper = null;
            const uploadInput = document.getElementById('image-upload');
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

                cropperWrapper.style.display = 'block';
                previewWrapper.style.display = 'none';
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

                // Jpeg export to eliminate PNG alpha-channel crashes
                const base64 = canvas.toDataURL('image/jpeg', 0.95);
                hiddenInput.value = base64;
                croppedPreview.src = base64;

                cropperWrapper.style.display = 'none';
                previewWrapper.style.display = 'block';

                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                submitBtn.classList.add('hover:brightness-110');
            });
        });
    </script>
</x-app-layout>
