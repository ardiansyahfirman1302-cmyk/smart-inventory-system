<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900" data-testid="register-heading">Buat akun baru 🚀</h2>
        <p class="mt-1 text-sm text-slate-500">Mulai kelola inventory Anda dengan Smart Inventory AI.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" data-testid="register-form">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       data-testid="register-name-input"
                       placeholder="Nama Anda"
                       class="w-full pl-10 pr-3 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
            </div>
            @error('name') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       data-testid="register-email-input"
                       placeholder="you@company.com"
                       class="w-full pl-10 pr-3 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
            </div>
            @error('email') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Password</label>
            <div class="relative" x-data="{ show: false }">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </span>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                       data-testid="register-password-input"
                       placeholder="Minimal 8 karakter"
                       class="w-full pl-10 pr-10 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
                <button type="button" @click="show = !show" tabindex="-1"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                    <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                    <i x-show="show" data-lucide="eye-off" class="w-4 h-4" x-cloak></i>
                </button>
            </div>
            @error('password') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       data-testid="register-password-confirmation-input"
                       placeholder="Ulangi password"
                       class="w-full pl-10 pr-3 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
            </div>
            @error('password_confirmation') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                data-testid="register-submit-btn"
                class="w-full py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-700 hover:to-fuchsia-700 text-white text-sm font-semibold shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Buat Akun
        </button>

        <p class="text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800" data-testid="go-to-login-link">
                Masuk di sini
            </a>
        </p>
    </form>

    <style>[x-cloak] { display: none !important; }</style>
</x-guest-layout>
