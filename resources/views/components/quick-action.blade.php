@props([
    'label',
    'icon' => 'plus',
    'color' => 'indigo',
    'href' => '#',
    'testid' => null,
])

@php
    $palette = [
        'indigo'  => 'from-indigo-500 to-indigo-600 shadow-indigo-500/30',
        'emerald' => 'from-emerald-500 to-emerald-600 shadow-emerald-500/30',
        'amber'   => 'from-amber-500 to-amber-600 shadow-amber-500/30',
        'rose'    => 'from-rose-500 to-rose-600 shadow-rose-500/30',
        'sky'     => 'from-sky-500 to-sky-600 shadow-sky-500/30',
        'slate'   => 'from-slate-700 to-slate-800 shadow-slate-500/30',
    ];
    $c = $palette[$color] ?? $palette['indigo'];
@endphp

<a href="{{ $href }}" data-testid="{{ $testid ?? 'quick-action-btn' }}"
   class="group flex flex-col items-start gap-3 p-4 rounded-xl bg-gradient-to-br {{ $c }} text-white shadow-md hover:-translate-y-0.5 hover:shadow-xl transition-all duration-200">
    <div class="w-10 h-10 rounded-lg bg-white/15 backdrop-blur flex items-center justify-center">
        <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
    </div>
    <p class="text-sm font-semibold leading-tight">{{ $label }}</p>
    <span class="text-[11px] opacity-80 inline-flex items-center gap-1 mt-auto">
        Buka
        <i data-lucide="arrow-right" class="w-3 h-3 transition-transform group-hover:translate-x-0.5"></i>
    </span>
</a>
