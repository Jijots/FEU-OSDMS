<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <div class="sticky top-0 bg-white border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <a href="{{ route('assets.lost-ids') }}" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </div>
        <div class="text-right">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Dossier View</p>
            <p class="text-xs font-black text-[#004d32] tracking-tighter">ID #{{ $asset->id }}</p>
        </div>
    </div>

    <div class="py-12 bg-[#FCFCFC]" style="zoom: 0.90;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-100 p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                    <div class="space-y-6">
                        <h1 class="text-6xl font-black text-slate-900 tracking-tighter">ID Card</h1>
                        <div class="rounded-[2.5rem] border-[10px] border-slate-50 overflow-hidden shadow-xl aspect-square bg-slate-50">
                            <img src="{{ $asset->image_url }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        </div>
                    </div>

                    <div class="space-y-12">
                        <div class="p-8 bg-slate-50/50 rounded-[2rem] border border-slate-100">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Log Details</h3>
                            <p class="text-lg font-bold text-slate-600 leading-relaxed mb-6">{{ $asset->description }}</p>
                            <div class="flex gap-4">
                                <span class="px-5 py-2 bg-white rounded-xl border border-slate-200 text-sm font-black text-slate-900">{{ $asset->status }}</span>
                                <span class="px-5 py-2 bg-white rounded-xl border border-slate-200 text-sm font-black text-slate-900">{{ $asset->location_found }}</span>
                            </div>
                        </div>

                        <div class="p-2 space-y-10">
                            <h3 class="text-[10px] font-black text-[#004d32] uppercase tracking-[0.4em]">Semantic AI Match Results</h3>

                            @if($student)
                                <div class="p-8 rounded-[2rem] border-2 border-[#004d32] bg-green-50/20">
                                    <p class="text-[10px] text-[#004d32] font-black mb-4 uppercase tracking-tighter">Identity Verified</p>
                                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter mb-1">{{ $student->name }}</h2>
                                    <p class="text-xl font-black text-[#004d32] tracking-widest">{{ $student->id_number }}</p>

                                    <form action="{{ route('assets.confirm', $asset->id) }}" method="POST" class="mt-8">
                                        @csrf
                                        <button type="submit" class="w-full py-5 rounded-2xl bg-[#004d32] text-white font-black uppercase tracking-[0.2em] text-[10px] shadow-xl hover:brightness-110">
                                            Confirm & Release ID
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="space-y-8">
                                    <div class="p-6 bg-red-50 rounded-2xl border border-red-100">
                                        <p class="text-xs font-bold text-red-900">Drift Detected: No directory match. Manual review required.</p>
                                    </div>

                                    <form action="{{ route('assets.compare', $asset->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Student Full Name</label>
                                                <input type="text" name="manual_name" placeholder="As seen on ID"
                                                    class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-xs focus:ring-1 focus:ring-slate-200" required>
                                            </div>
                                            <div class="space-y-2">
                                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Student ID Number</label>
                                                <input type="text" name="manual_id" placeholder="Ex: 202310790"
                                                    class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-xs focus:ring-1 focus:ring-slate-200" required>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Academic Program</label>
                                            <input type="text" name="manual_program" placeholder="Ex: BSITWMA"
                                                class="w-full px-8 py-5 rounded-2xl bg-slate-50 border-none font-bold text-slate-700 text-xs focus:ring-1 focus:ring-slate-200" required>
                                        </div>

                                        <div class="space-y-4">
                                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Verification Capture</label>

                                            <input type="file" id="image-upload" accept="image/*" class="w-full text-[10px] text-slate-400 file:mr-6 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-slate-900 file:text-white hover:file:bg-[#004d32] cursor-pointer">

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

                                        <button type="submit" id="submit-btn" class="w-full py-5 rounded-2xl bg-[#004d32] text-white font-black uppercase tracking-[0.2em] text-[10px] shadow-lg opacity-50 cursor-not-allowed" disabled>
                                            Execute Multi-Field Scan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
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
