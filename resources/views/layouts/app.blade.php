<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($pageTitle) ? $pageTitle . ' — ' : '' }}{{ config('app.name', 'Smart Inventory AI') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Lucide icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <div class="min-h-screen">
        {{-- Dark Sidebar --}}
        <x-sidebar />

        {{-- Main content wrapper --}}
        <div class="lg:pl-64 flex flex-col min-h-screen" x-data>
            <x-topbar :title="$pageTitle ?? 'Dashboard'" :subtitle="$pageSubtitle ?? null" />

            @isset($header)
                <div class="px-4 lg:px-8 pt-6">
                    {{ $header }}
                </div>
            @endisset

            <main class="flex-1 px-4 lg:px-8 py-6" data-testid="page-main">
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm" data-testid="flash-status">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="px-4 lg:px-8 py-4 text-xs text-slate-400 border-t border-slate-200/60">
                © {{ date('Y') }} Smart Inventory AI · Inventory & Asset Management System
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
        document.addEventListener('livewire:navigated', () => window.lucide?.createIcons());
    </script>

    @stack('scripts')
</body>
</html>
