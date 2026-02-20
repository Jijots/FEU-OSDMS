<x-app-layout>
    <div class="sticky top-0 bg-white border-b border-slate-100 z-40 px-12 py-6 flex items-center justify-between">
        <div class="flex items-center gap-10">
            <a href="{{ route('assets.lost-ids') }}" class="p-3 hover:bg-slate-100 rounded-2xl transition-all">
                <svg class="w-7 h-7 text-[#004d32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-12 w-auto">
        </div>
        <div class="text-right">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Vault Entry</p>
            <p class="text-xs font-black text-[#004d32] tracking-tighter">NEW ID LOG</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto py-16">
        <form action="{{ route('assets.store-id') }}" method="POST" enctype="multipart/form-data" class="bg-white p-12 rounded-[2.5rem] shadow-2xl border border-slate-100" x-data="{ photoPreview: null }">
            @csrf
            <div class="space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Student Full Name</label>
                        <input type="text" name="student_name" placeholder="Exactly as seen on ID" class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-sm focus:ring-1 focus:ring-slate-200" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Student ID Number</label>
                        <input type="text" name="student_id" placeholder="Ex: 202310790" class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-sm focus:ring-1 focus:ring-slate-200" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Academic Program</label>
                        <input type="text" name="program" placeholder="Ex: BSITWMA" class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-sm focus:ring-1 focus:ring-slate-200" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Location Found</label>
                        <input type="text" name="location_found" placeholder="Gate / Canteen / Room" class="w-full px-6 py-4 rounded-xl bg-slate-50 border-none font-bold text-slate-700 text-sm focus:ring-1 focus:ring-slate-200" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Security Capture</label>
                    <div class="border-4 border-dashed border-slate-50 rounded-[2rem] p-10 text-center hover:border-[#004d32] transition-colors bg-slate-50/50">
                        <template x-if="photoPreview"><img :src="photoPreview" class="h-48 mx-auto rounded-2xl object-contain mb-6 shadow-xl"></template>
                        <input type="file" name="image" class="hidden" x-ref="photo" @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" required>
                        <button type="button" @click="$refs.photo.click()" class="bg-slate-900 text-white px-10 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#004d32] transition-colors">Select ID Photo</button>
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <a href="{{ route('assets.lost-ids') }}" class="flex-1 text-center py-5 font-black text-slate-300 uppercase text-xs no-underline">Cancel</a>
                    <button type="submit" class="flex-[2] py-5 bg-[#004d32] text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-xl hover:brightness-110 transition-all">Submit to Vault</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
