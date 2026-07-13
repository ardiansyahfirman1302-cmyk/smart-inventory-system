@props([
    'title',
    'subtitle' => null,
    'searchPlaceholder' => 'Cari...',
    'createUrl' => null,
    'createLabel' => 'Tambah',
    'showSearch' => true,
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5" data-testid="toolbar">
    <div>
        <h1 class="text-xl font-bold text-slate-900" data-testid="page-title">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-sm text-slate-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="flex items-center gap-2">
        @if ($showSearch)
            <form method="GET" class="relative" data-testid="search-form">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="{{ $searchPlaceholder }}"
                       data-testid="search-input"
                       class="pl-10 pr-3 py-2 w-full sm:w-64 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition" />
            </form>
        @endif
        @if ($createUrl)
            <x-btn :href="$createUrl" icon="plus" data-testid="btn-create">
                {{ $createLabel }}
            </x-btn>
        @endif
    </div>
</div>
