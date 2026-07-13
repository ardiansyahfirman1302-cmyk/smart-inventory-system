<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900" data-testid="login-heading">Selamat datang di Smart Inventory 👋</h2>
        <p class="mt-1 text-sm text-slate-500">Masuk ke dashboard Smart Inventory AI untuk melanjutkan.</p>
    </div>


    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm" data-testid="session-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5" data-testid="login-form">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       data-testid="login-email-input"
                       placeholder="you@company.com"
                       class="w-full pl-10 pr-3 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-rose-600" data-testid="login-email-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800" data-testid="forgot-password-link">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </span>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       data-testid="login-password-input"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-10 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
                <button type="button" @click="show = !show" tabindex="-1"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700"
                        data-testid="toggle-password-visibility">
                    <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                    <i x-show="show" data-lucide="eye-off" class="w-4 h-4" x-cloak></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-rose-600" data-testid="login-password-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember --}}
        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" data-testid="login-remember-checkbox">
            <span class="text-sm text-slate-600">Ingat saya di perangkat ini</span>
        </label>

        {{-- Submit --}}
        <button type="submit"
                data-testid="login-submit-btn"
                class="w-full py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-700 hover:to-fuchsia-700 text-white text-sm font-semibold shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
            <i data-lucide="log-in" class="w-4 h-4"></i>
            Masuk ke Dashboard
        </button>

        {{-- Divider --}}
        <div class="relative flex items-center py-2">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="mx-3 text-[10px] uppercase tracking-widest text-slate-400">Atau</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <p class="text-center text-sm text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800" data-testid="go-to-register-link">
                Daftar sekarang
            </a>
        </p>
    </form>

    <style>[x-cloak] { display: none !important; }</style>
</x-guest-layout>
