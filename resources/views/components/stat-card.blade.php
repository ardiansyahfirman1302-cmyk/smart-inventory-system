@props([
    'label',
    'value',
    'icon' => 'circle',
    'color' => 'indigo',
    'delta' => null,
    'deltaTone' => 'positive',
    'suffix' => null,
    'testid' => null,
])

@php
    $palette = [
        'indigo'  => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'ring' => 'ring-indigo-100'],
        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-100'],
        'amber'   => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'ring-amber-100'],
        'rose'    => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'ring' => 'ring-rose-100'],
        'sky'     => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'ring' => 'ring-sky-100'],
        'violet'  => ['bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'ring' => 'ring-violet-100'],
    ];
    $c = $palette[$color] ?? $palette['indigo'];
    $deltaClass = $deltaTone === 'negative' ? 'text-rose-600 bg-rose-50' : ($deltaTone === 'neutral' ? 'text-slate-600 bg-slate-100' : 'text-emerald-600 bg-emerald-50');
@endphp

<div class="group bg-white rounded-2xl p-5 border border-slate-200 hover:shadow-lg hover:border-slate-300 transition-all duration-200"
     data-testid="{{ $testid ?? 'stat-card' }}">
    <div class="flex items-start justify-between mb-4">
        <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} {{ $c['text'] }} ring-4 {{ $c['ring'] }} flex items-center justify-center">
            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
        </div>
        @if ($delta !== null)
            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full {{ $deltaClass }}">
                <i data-lucide="{{ $deltaTone === 'negative' ? 'trending-down' : ($deltaTone === 'neutral' ? 'minus' : 'trending-up') }}" class="w-3 h-3"></i>
                {{ $delta }}
            </span>
        @endif
    </div>

    <p class="text-xs uppercase tracking-wider text-slate-500 mb-1">{{ $label }}</p>
    <p class="text-2xl font-bold text-slate-900">
        {{ $value }}
        @if ($suffix)
            <span class="text-sm font-medium text-slate-400">{{ $suffix }}</span>
        @endif
    </p>
</div>
