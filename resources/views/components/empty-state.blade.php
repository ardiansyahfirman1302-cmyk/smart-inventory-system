@props(['message' => 'Belum ada data.', 'icon' => 'inbox', 'action' => null])

<div class="py-16 text-center" data-testid="empty-state">
    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-slate-100 text-slate-400 mb-3">
        <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
    </div>
    <p class="text-sm text-slate-500">{{ $message }}</p>
    @if ($action)
        <div class="mt-4">{{ $action }}</div>
    @endif
</div>
