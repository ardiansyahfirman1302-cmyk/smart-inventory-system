@props([
    'variant' => 'primary',
    'icon' => null,
    'href' => null,
    'type' => 'button',
    'size' => 'md',
])

@php
    $palette = [
        'primary'   => 'bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-700 hover:to-fuchsia-700 text-white shadow-md shadow-indigo-500/30',
        'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50',
        'danger'    => 'bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-500/30',
        'ghost'     => 'text-slate-600 hover:bg-slate-100',
    ];
    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-5 py-2.5 text-sm gap-2',
    ];
    $c = $palette[$variant] ?? $palette['primary'];
    $s = $sizes[$size] ?? $sizes['md'];
    $classes = "inline-flex items-center justify-center rounded-lg font-semibold transition transform hover:-translate-y-0.5 $c $s";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i data-lucide="{{ $icon }}" class="w-4 h-4"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i data-lucide="{{ $icon }}" class="w-4 h-4"></i>@endif
        {{ $slot }}
    </button>
@endif
