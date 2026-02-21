<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <div class="max-w-4xl mx-auto px-8 lg:px-12 py-10">

        <div class="mb-10 flex items-center justify-between border-b-2 border-slate-100 pb-6">
            <div>
                <a href="{{ route('assets.lost-ids') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#004d32] transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Vault
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Log Found ID Card</h1>
            </div>
            <span class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm border-2 border-slate-200 uppercase tracking-wide">ID Entry</span>
        </div>

        <form action="{{ route('assets.store-id') }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white border-2 border-slate-200 rounded-2xl p-10 shadow-sm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Student Name</label>
                    <input type="text" name="student_name" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 transition-colors" placeholder="Name on the ID..." required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Student ID Number</label>
                    <input type="text" name="student_id" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 transition-colors" placeholder="e.g. 202310001" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Program / Course</label>
                    <input type="text" name="program" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 transition-colors" placeholder="e.g. BSIT" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Location Found</label>
                    <input type="text" name="location_found" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 text-base font-semibold text-slate-800 focus:border-[#004d32] focus:ring-0 transition-colors" placeholder="e.g. Library, Main Gate" required>
                </div>
            </div>

            <div class="border-t-2 border-slate-100 pt-8">
                <label class="block text-sm font-bold text-slate-700 mb-4">ID Capture (Required)</label>

                <div class="border-4 border-dashed border-slate-200 rounded-2xl p-10 text-center hover:border-[#004d32] transition-colors cursor-pointer bg-slate-50 mb-6" onclick="document.getElementById('image_input').click()" id="uploadWrapper">
                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                    <span class="block text-sm font-bold text-slate-600">Click to capture ID Image</span>
                    <input type="file" id="image_input" accept="image/*" class="hidden">
                </div>

                <div id="cropperWrapper" class="hidden mb-6">
                    <div class="h-[400px] bg-slate-900 rounded-2xl overflow-hidden border-4 border-slate-200 mb-4">
                        <img id="cropperImage" class="max-w-full">
                    </div>
                    <button type="button" id="cropButton" class="w-full py-4 bg-slate-800 text-white font-bold text-base rounded-xl hover:bg-slate-700 transition-colors shadow-sm">
                        Confirm Area & Prepare ID
                    </button>
                </div>

                <div id="previewWrapper" class="hidden mb-6 text-center">
                    <span class="block text-sm font-bold text-green-600 mb-4">ID Capture Ready for Vault</span>
                    <div class="border-4 border-slate-200 rounded-2xl p-4 bg-white inline-block">
                        <img id="croppedPreview" class="h-48 object-contain rounded-lg">
                    </div>
                </div>

                <input type="hidden" name="cropped_image" id="cropped_image">
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-2 border-slate-100">
                <a href="{{ route('assets.lost-ids') }}" class="w-full sm:w-auto px-8 py-4 text-center text-base font-bold text-slate-600 bg-white border-2 border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" id="submitBtn" disabled class="w-full py-4 bg-[#004d32] text-white text-base font-bold rounded-xl opacity-50 cursor-not-allowed transition-all text-center flex-1 border-2 border-transparent">
                    Secure ID to Vault
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cropper = null;
            const fileInput = document.getElementById('image_input');
            const cropperImage = document.getElementById('cropperImage');
            const cropperWrapper = document.getElementById('cropperWrapper');
            const uploadWrapper = document.getElementById('uploadWrapper');
            const cropButton = document.getElementById('cropButton');
            const previewWrapper = document.getElementById('previewWrapper');
            const croppedPreview = document.getElementById('croppedPreview');
            const hiddenInput = document.getElementById('cropped_image');
            const submitBtn = document.getElementById('submitBtn');

            if(fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    uploadWrapper.style.display = 'none';
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
            }

            if(cropButton) {
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
                    submitBtn.classList.add('hover:bg-green-800', 'shadow-md');
                });
            }
        });
    </script>
</x-app-layout>
