<x-guest-layout>
    <div class="text-center mb-10">
        <div class="inline-block">
            <img src="{{ asset('images/FEU-Logo.png') }}"
                 alt="Far Eastern University"
                 class="h-28 w-auto mx-auto mb-10 drop-shadow-2xl object-contain">
        </div>

        <h1 class="text-7xl font-black text-slate-900 tracking-tighter leading-none mb-4 uppercase">Command Center</h1>
        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.5em] opacity-80">Intelligence Division Access</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}"
          class="bg-white p-14 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.08)] border border-slate-100">
        @csrf

        <div class="space-y-8">
            <div>
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-6">Terminal ID / Email</label>
                <input type="email" name="email" :value="old('email')" required autofocus
                       class="w-full px-10 py-6 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-[#004d32]/10 transition-all text-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-3 ml-6" />
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-6">Access Key</label>
                <input type="password" name="password" required
                       class="w-full px-10 py-6 rounded-full bg-slate-50 border-none font-bold text-slate-900 focus:ring-4 focus:ring-[#004d32]/10 transition-all text-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-3 ml-6" />
            </div>

            <div class="flex items-center justify-between px-6">
                <label class="inline-flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-200 text-[#004d32] focus:ring-[#004d32]">
                    <span class="ml-4 text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">Maintain Session</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-slate-300 hover:text-[#004d32] uppercase tracking-widest no-underline transition-colors">
                        Forgot Key?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full py-7 mt-6 bg-[#004d32] text-white rounded-full font-black uppercase tracking-[0.3em] text-[11px] shadow-2xl shadow-green-900/40 hover:brightness-110 hover:-translate-y-1 transition-all active:scale-95">
                Initialize Access
            </button>
        </div>
    </form>

    <div class="mt-16 text-center">
        <div class="flex items-center justify-center gap-4 mb-4">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Secure Terminal Link Active</span>
        </div>
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.6em]">FEU-OSD Intelligence Protocol v2026</p>
    </div>
</x-guest-layout>
