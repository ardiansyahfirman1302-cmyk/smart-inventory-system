<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? 'Masuk' }} — {{ config('app.name', 'Smart Inventory AI') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900">

    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Left: Brand panel --}}
        <div class="relative hidden lg:flex flex-col justify-between p-12 bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 text-white overflow-hidden">
            {{-- decorative --}}
            <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(255,255,255,.6) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.6) 1px, transparent 1px); background-size: 40px 40px;"></div>

            {{-- Brand --}}
            <div class="relative flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-fuchsia-500 flex items-center justify-center shadow-xl shadow-indigo-500/40">
                    <i data-lucide="boxes" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">Smart Inventory</p>
                    <p class="text-[11px] uppercase tracking-widest text-indigo-300">AI Platform</p>
                </div>
            </div>

            {{-- Hero --}}
            <div class="relative">
                <p class="text-xs uppercase tracking-widest text-fuchsia-300 mb-3">Inventory & Asset Management</p>
                <h1 class="text-4xl xl:text-5xl font-extrabold leading-tight">
                    Kendalikan stok, <br>
                    <span class="bg-gradient-to-r from-fuchsia-300 to-indigo-300 bg-clip-text text-transparent">tingkatkan efisiensi.</span>
                </h1>
                <p class="mt-4 text-slate-300 max-w-md leading-relaxed">
                    Platform manajemen inventory modern dengan rekomendasi cerdas berbasis AI —
                    pantau barang, transaksi, dan maintenance dalam satu dashboard.
                </p>

                {{-- Feature bullets --}}
                <ul class="mt-8 space-y-3 text-sm">
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-md bg-white/10 border border-white/20 flex items-center justify-center">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </span>
                        Real-time monitoring stok & lokasi gudang
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-md bg-white/10 border border-white/20 flex items-center justify-center">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </span>
                        AI Recommendation: low stock, dead stock, fast-mover
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-md bg-white/10 border border-white/20 flex items-center justify-center">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </span>
                        Multi-role: Admin, Manager, Staff
                    </li>
                </ul>
            </div>

            {{-- Footer --}}
            <div class="relative text-xs text-slate-400">
                © {{ date('Y') }} Smart Inventory AI — Built for enterprise
            </div>
        </div>

        {{-- Right: Form panel --}}
        <div class="flex items-center justify-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md">

                {{-- Mobile brand --}}
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-fuchsia-500 flex items-center justify-center shadow-lg shadow-indigo-500/40">
                        <i data-lucide="boxes" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <p class="text-base font-bold text-slate-900">Smart Inventory AI</p>
                        <p class="text-[10px] uppercase tracking-widest text-indigo-600">Inventory Platform</p>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => window.lucide?.createIcons());
    </script>
</body>
</html>
