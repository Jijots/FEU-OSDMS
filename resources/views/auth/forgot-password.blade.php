<x-guest-layout>
    <div class="text-center mb-12">
        <img src="{{ asset('images/LOGO.png') }}" alt="FEU-OSDMS" class="h-16 mx-auto mb-8">
        <h1 class="text-6xl font-black text-slate-900 tracking-tighter leading-none mb-4">Command Center</h1>
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">Intelligence Division Access</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white p-12 rounded-[3.5rem] shadow-2xl shadow-slate-200 border border-slate-100">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Terminal ID / Email</label>
                <input type="email" name="email" :value="old('email')" required autofocus
                       class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-2 focus:ring-[#004d32] transition-all">
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Access Key</label>
                <input type="password" name="password" required
                       class="w-full px-8 py-5 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-2 focus:ring-[#004d32] transition-all">
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
            </div>

            <div class="flex items-center justify-between px-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-200 text-[#004d32] focus:ring-[#004d32]">
                    <span class="ml-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Maintain Session</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-slate-300 hover:text-[#004d32] uppercase tracking-widest no-underline transition-colors">
                        Forgot Key?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full py-6 mt-4 bg-[#004d32] text-white rounded-full font-black uppercase tracking-[0.2em] text-xs shadow-2xl shadow-green-900/20 hover:brightness-110 transition-all">
                Initialize Access
            </button>
        </div>
    </form>

    <div class="mt-12 text-center">
        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.5em]">FEU-OSD Intelligence Protocol v2026</p>
    </div>
</x-guest-layout>
