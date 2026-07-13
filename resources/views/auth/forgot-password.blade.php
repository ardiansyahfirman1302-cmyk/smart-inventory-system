<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Lupa password?</h2>
        <p class="mt-1 text-sm text-slate-500">
            Tenang, masukkan email Anda dan kami akan mengirimkan tautan reset password.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm" data-testid="forgot-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" data-testid="forgot-form">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       data-testid="forgot-email-input"
                       placeholder="you@company.com"
                       class="w-full pl-10 pr-3 py-2.5 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
            </div>
            @error('email') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                data-testid="forgot-submit-btn"
                class="w-full py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-700 hover:to-fuchsia-700 text-white text-sm font-semibold shadow-lg shadow-indigo-500/30 transition flex items-center justify-center gap-2">
            <i data-lucide="send" class="w-4 h-4"></i>
            Kirim Tautan Reset
        </button>

        <p class="text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke halaman masuk
            </a>
        </p>
    </form>
</x-guest-layout>
