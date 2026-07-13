@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'required' => false,
    'placeholder' => '-- Pilih --',
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

    <select id="{{ $id }}" name="{{ $name }}"
        @if ($required) required @endif
        data-testid="select-{{ $name }}"
        {{ $attributes->except(['id'])->merge(['class' => 'w-full px-3 py-2.5 text-sm rounded-lg border ' . ($hasError ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-100' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-100') . ' focus:ring-2 outline-none transition bg-white']) }}>
        @unless ($required)
            <option value="">{{ $placeholder }}</option>
        @else
            <option value="" disabled @if (empty($val)) selected @endif>{{ $placeholder }}</option>
        @endunless
        @foreach ($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected((string) $val === (string) $optValue)>{{ $optLabel }}</option>
        @endforeach
    </select>

    @if ($help && !$hasError)
        <p class="mt-1.5 text-xs text-slate-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs text-rose-600" data-testid="error-{{ $name }}">{{ $message }}</p>
    @enderror
</div>
