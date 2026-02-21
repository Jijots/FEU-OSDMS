<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <div class="sticky top-0 bg-white/95 backdrop-blur-3xl border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
            </a>
        </div>

        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] leading-none mb-1">System Terminal</p>
                <p class="text-xs font-black text-[#004d32] tracking-tighter">OSD-ADMIN-{{ auth()->id() }}</p>
            </div>
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse border-4 border-green-50"></div>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-100 p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest">Record #{{ $item->id }}</span>
                        </div>
                        <h1 class="text-6xl font-black text-slate-900 tracking-tighter">{{ $item->item_category }}</h1>
                        <div class="rounded-[2.5rem] border-[10px] border-slate-50 overflow-hidden shadow-xl aspect-square">
                            <img src="{{ $item->image_url }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Report Details</h3>
                            <div class="text-sm font-medium text-slate-500 space-y-2">
                                <p><strong class="text-slate-900">Type:</strong> {{ $item->report_type }}</p>
                                <p><strong class="text-slate-900">Description:</strong> {{ $item->description }}</p>
                            </div>
                        </div>

                        <form action="{{ route('assets.compare', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="comparison-form">
                            @csrf
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Input Security Capture</label>

                                <input type="file" id="image-upload" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">

                                <div id="cropper-wrapper" style="display: none;" class="mt-4 bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <div style="max-height: 400px; width: 100%; overflow: hidden;" class="rounded-xl border border-slate-200 bg-black">
                                        <img id="cropper-image" style="display: block; max-width: 100%;">
                                    </div>
                                    <button type="button" id="crop-button" class="w-full py-3 mt-4 rounded-xl bg-slate-800 text-white font-black uppercase tracking-[0.2em] text-[10px] hover:bg-slate-900 transition-colors">
                                        Confirm Free Crop
                                    </button>
                                </div>

                                <div id="preview-wrapper" style="display: none;" class="mt-4 text-center">
                                    <p class="text-[9px] font-black text-green-600 uppercase mb-2 tracking-widest">Ready for Analysis</p>
                                    <img id="cropped-preview" class="mx-auto rounded-xl border-4 border-slate-100 max-h-64 max-w-full object-contain shadow-lg">
                                    <input type="hidden" name="cropped_image" id="cropped_image_input" required>
                                </div>
                            </div>

                            <button type="submit" id="submit-btn" style="background-color: #004d32;" class="w-full py-5 rounded-2xl text-white font-black uppercase tracking-widest text-xs shadow-lg hover:brightness-110 transition-all opacity-50 cursor-not-allowed" disabled>
                                Execute Comparison
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

            if(uploadInput) {
                uploadInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    cropperWrapper.style.display = 'block';
                    previewWrapper.style.display = 'none';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        cropperImage.src = event.target.result;

                        // Destroy old instance if it exists
                        if (cropper) { cropper.destroy(); }

                        // Initialize FREE-SIZE Cropper.js
                        cropper = new Cropper(cropperImage, {
                            viewMode: 1, // Restrict crop box to not exceed canvas
                            autoCropArea: 0.9,
                            responsive: true,
                            guides: true,
                            center: true,
                            highlight: false,
                            background: false,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            // Notice: We do NOT define an 'aspectRatio', which enables free cropping!
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }

            if(cropButton) {
                cropButton.addEventListener('click', function() {
                    if (!cropper) return;

                    const canvas = cropper.getCroppedCanvas({
                        maxWidth: 1024,
                        maxHeight: 1024,
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    });

                    const base64 = canvas.toDataURL('image/png');
                    hiddenInput.value = base64;
                    croppedPreview.src = base64;

                    cropperWrapper.style.display = 'none';
                    previewWrapper.style.display = 'block';

                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
        });
    </script>
</x-app-layout>
