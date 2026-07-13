@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'padding' => 'p-6',
    'action' => null,
])

<section {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200 overflow-hidden']) }}>
    @if ($title || $icon || $action)
        <header class="flex items-center justify-between gap-3 px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3 min-w-0">
                @if ($icon)
                    <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    @if ($title)
                        <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $title }}</h3>
                    @endif
                    @if ($subtitle)
                        <p class="text-xs text-slate-500 truncate">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if ($action)
                <div>{{ $action }}</div>
            @endif
        </header>
    @endif
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</section>
