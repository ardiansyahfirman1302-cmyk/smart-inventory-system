@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'icon' => null,
    'help' => null,
])

@php
    $id = $attributes->get('id', $name);
    $val = old($name, $value);
    $hasError = $errors->has($name);
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">
            {{ $label }} @if ($required) <span class="text-rose-500">*</span> @endif
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
            </span>
        @endif
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ $val }}"
            @if ($required) required @endif
            placeholder="{{ $placeholder }}"
            data-testid="input-{{ $name }}"
            {{ $attributes->except(['id']) }}
            class="w-full {{ $icon ? 'pl-10' : 'pl-3' }} pr-3 py-2.5 text-sm rounded-lg border {{ $hasError ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-100' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-100' }} focus:ring-2 outline-none transition placeholder:text-slate-400" />
    </div>

    @if ($help && !$hasError)
        <p class="mt-1.5 text-xs text-slate-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs text-rose-600" data-testid="error-{{ $name }}">{{ $message }}</p>
    @enderror
</div>
