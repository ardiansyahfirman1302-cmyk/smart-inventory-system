<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">

    {{-- Hero AI card --}}
    <x-ai-card :recommendations="$recommendations" />

    {{-- Out of Stock --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-section-card title="⚠ Barang Habis Stok" subtitle="Prioritas tinggi — segera restock" icon="package-x" padding="p-0" data-testid="ai-outofstock-card">
            @if ($outOfStock->isEmpty())
                <x-empty-state message="Tidak ada barang habis stok. Semua aman!" icon="check-circle-2" />
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($outOfStock as $p)
                        <div class="flex items-center gap-3 px-6 py-3">
                            <div class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $p->name }}</p>
                                <p class="text-xs text-slate-500 font-mono">{{ $p->sku }} · {{ $p->category?->name }} · Supplier: {{ $p->supplier?->name ?? '-' }}</p>
                            </div>
                            <a href="{{ route('stock-ins.create') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 whitespace-nowrap">Restock →</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-section-card>

        <x-section-card title="🟡 Low Stock" subtitle="Stok di bawah minimum" icon="alert-triangle" padding="p-0" data-testid="ai-lowstock-card">
            @if ($lowStock->isEmpty())
                <x-empty-state message="Semua stok di atas minimum. 🎉" icon="check-circle-2" />
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($lowStock as $p)
                        <div class="px-6 py-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $p->name }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ $p->sku }} · {{ $p->category?->name }}</p>
                                </div>
                                <span class="text-xs font-semibold text-amber-600 whitespace-nowrap">{{ $p->stock }} / {{ $p->min_stock }}</span>
                            </div>
                            @php $pct = $p->min_stock > 0 ? min(100, round(($p->stock / $p->min_stock) * 100)) : 0; @endphp
                            <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-amber-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-section-card>
    </div>

    <div class="mt-6">
        <x-section-card title="🕰 Dead Stock (Tidak Bergerak > 90 hari)" subtitle="Pertimbangkan promosi atau relokasi" icon="archive" padding="p-0" data-testid="ai-deadstock-card">
            @if ($deadStock->isEmpty())
                <x-empty-state message="Tidak ada barang stagnan. Perputaran stok sehat!" icon="check-circle-2" />
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($deadStock as $p)
                        <div class="flex items-center gap-3 px-6 py-3">
                            <div class="w-9 h-9 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <i data-lucide="archive" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $p->name }}</p>
                                <p class="text-xs text-slate-500 font-mono">{{ $p->sku }} · {{ $p->category?->name }}</p>
                            </div>
                            <span class="text-sm font-semibold text-sky-600">{{ $p->stock }} stok</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-section-card>
    </div>

    <p class="mt-6 text-xs text-slate-400 flex items-center gap-1.5">
        <i data-lucide="info" class="w-3.5 h-3.5"></i>
        Analisis rule-based dari data inventory. Upgrade ke LLM (Gemini/GPT/Claude) tersedia via Emergent Universal Key.
    </p>
</x-app-layout>
