<x-guest-layout>
    <div class="flex flex-col items-center justify-center w-full mb-4 mt-2">
        <div class="w-full flex justify-center mb-2 p-1">
            <img src="{{ asset('images/FEU-Logo.png') }}"
                 alt="Far Eastern University"
                 style="height: 120px; width: auto; object-fit: contain;"
                 class="drop-shadow-2xl max-w-full">
        </div>

        <h1 style="font-family: 'DellaRobiaBT', 'Della Robbia BT', serif; font-size: 38px; color: #FECB02; letter-spacing: 0.05em;"
            class="leading-none drop-shadow-md uppercase text-center">
            LOGIN
        </h1>
        <p class="text-[10px] font-black text-[#FECB02]/70 uppercase tracking-[0.4em] mt-1 text-center">
            Office of Student Discipline
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto w-full px-6">
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[10px] font-bold text-[#FECB02] uppercase tracking-widest mb-1.5 ml-1">Email Address</label>
                <input type="email" name="email" :value="old('email')" required autofocus
                       placeholder="Enter your email address"
                       class="w-full px-5 py-3 bg-white border-none rounded-xl font-semibold text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-[#FECB02] transition-all text-sm outline-none shadow-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-[10px]" />
            </div>

            <div>
                <label class="block text-[10px] font-bold text-[#FECB02] uppercase tracking-widest mb-1.5 ml-1">Password</label>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="w-full px-5 py-3 bg-white border-none rounded-xl font-semibold text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-[#FECB02] transition-all text-sm outline-none shadow-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-[10px]" />
            </div>

            <div class="flex items-center justify-between mt-2">
                <label class="inline-flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-white/20 bg-transparent text-[#FECB02] focus:ring-[#FECB02]">
                    <span class="ml-2 text-[11px] font-bold text-white/60 group-hover:text-white transition-colors">Remember Me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-[#FECB02] hover:text-white no-underline transition-colors">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full py-4 mt-2 bg-[#FECB02] text-[#004d32] rounded-xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:brightness-110 hover:-translate-y-1 transition-all active:scale-95">
                LOGIN
            </button>
        </form>

        <div class="mt-6 text-center">
             <p class="text-[9px] font-black text-[#FECB02]/30 uppercase tracking-[0.5em]">FEU-OSD Intelligence Protocol v2026</p>
        </div>
    </div>
</x-guest-layout>
