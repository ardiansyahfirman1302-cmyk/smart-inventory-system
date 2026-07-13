<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">

    {{-- Date filter --}}
    <x-section-card padding="p-4" class="mb-4">
        <form method="GET" class="flex flex-col md:flex-row md:items-end gap-3" data-testid="report-filter-form">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Dari Tanggal</label>
                <input type="date" name="from" value="{{ $from->toDateString() }}" data-testid="report-from"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none" />
            </div>
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1.5">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ $to->toDateString() }}" data-testid="report-to"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none" />
            </div>
            <div class="flex items-end gap-2">
                <x-btn type="submit" variant="primary" icon="search" data-testid="btn-report-apply">Terapkan</x-btn>
                <x-btn variant="secondary" icon="printer" onclick="window.print()">Print</x-btn>
            </div>
        </form>
        <p class="text-xs text-slate-500 mt-3">
            Periode: <span class="font-semibold text-slate-700">{{ $from->translatedFormat('d M Y') }}</span>
            – <span class="font-semibold text-slate-700">{{ $to->translatedFormat('d M Y') }}</span>
        </p>
    </x-section-card>

    {{-- KPI Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card label="Total Barang Masuk" :value="number_format($totalIn)" icon="arrow-down-to-line" color="emerald" testid="report-stat-in" />
        <x-stat-card label="Total Barang Keluar" :value="number_format($totalOut)" icon="arrow-up-from-line" color="violet" testid="report-stat-out" />
        <x-stat-card label="Nilai Pembelian" :value="'Rp ' . number_format($totalInValue, 0, ',', '.')" icon="banknote" color="indigo" testid="report-stat-value" />
        <x-stat-card label="Tiket Maintenance" :value="number_format($mntCount)" icon="wrench" color="amber" testid="report-stat-mnt" />
    </div>

    {{-- Data blocks --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-section-card title="Top 5 Barang Keluar" subtitle="Barang paling banyak keluar di periode ini" icon="trending-up" padding="p-0" data-testid="report-topout">
            @if ($topOut->isEmpty())
                <x-empty-state message="Tidak ada data pengeluaran di periode ini." />
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($topOut as $i => $row)
                        <div class="flex items-center gap-3 px-6 py-3">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-fuchsia-500 text-white text-xs font-bold flex items-center justify-center">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $row->product?->name }}</p>
                                <p class="text-xs text-slate-500 font-mono">{{ $row->product?->sku }}</p>
                            </div>
                            <p class="text-sm font-semibold text-violet-600">{{ number_format($row->total_qty) }} qty</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-section-card>

        <x-section-card title="Stok per Kategori" subtitle="Distribusi stok berdasarkan kategori" icon="tags" padding="p-0" data-testid="report-stock-by-cat">
            @if ($stockByCategory->isEmpty())
                <x-empty-state message="Belum ada kategori." />
            @else
                <div class="divide-y divide-slate-100">
                    @php $maxStock = max($stockByCategory->max('total_stock') ?? 1, 1); @endphp
                    @foreach ($stockByCategory as $cat)
                        @php $pct = round(((int) $cat->total_stock / $maxStock) * 100); @endphp
                        <div class="px-6 py-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-sm font-medium text-slate-900">{{ $cat->name }}</p>
                                <p class="text-xs text-slate-500">{{ $cat->products_count }} barang · {{ number_format((int) $cat->total_stock) }} stok</p>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-fuchsia-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-section-card>
    </div>

    <div class="mt-6">
        <x-section-card title="Distribusi Status Maintenance" icon="wrench" data-testid="report-mnt-status">
            @if ($maintenanceStatus->isEmpty())
                <x-empty-state message="Belum ada tiket di periode ini." />
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                        @php $count = $maintenanceStatus[$status] ?? 0; @endphp
                        <div class="rounded-xl border border-slate-200 p-4">
                            <x-status-badge :status="$status" />
                            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $count }}</p>
                            <p class="text-xs text-slate-500">Tiket</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-section-card>
    </div>

    @push('head')
    <style>
        @media print {
            aside, header[data-testid="app-topbar"], footer, form { display: none !important; }
            .lg\:pl-64 { padding-left: 0 !important; }
            main { padding: 0 !important; }
        }
    </style>
    @endpush
</x-app-layout>
