<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <x-toolbar :title="$pageTitle" :subtitle="$pageSubtitle" searchPlaceholder="Cari referensi, barang..."
        :createUrl="route('stock-ins.create')" createLabel="Input Barang Masuk" />

    <x-section-card padding="p-0">
        @if ($stockIns->isEmpty())
            <x-empty-state message="Belum ada transaksi masuk." icon="arrow-down-to-line" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" data-testid="stock-ins-table">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">Ref</th>
                            <th class="text-left px-6 py-3 font-semibold">Tanggal</th>
                            <th class="text-left px-6 py-3 font-semibold">Barang</th>
                            <th class="text-left px-6 py-3 font-semibold">Supplier</th>
                            <th class="text-center px-6 py-3 font-semibold">Qty</th>
                            <th class="text-right px-6 py-3 font-semibold">Total</th>
                            <th class="text-left px-6 py-3 font-semibold">User</th>
                            <th class="text-right px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($stockIns as $tx)
                            <tr class="hover:bg-slate-50" data-testid="row-stockin-{{ $tx->id }}">
                                <td class="px-6 py-3 font-mono text-xs text-slate-700">{{ $tx->reference_no }}</td>
                                <td class="px-6 py-3 text-slate-700">{{ optional($tx->transaction_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-3">
                                    <p class="font-medium text-slate-900">{{ $tx->product?->name }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ $tx->product?->sku }}</p>
                                </td>
                                <td class="px-6 py-3 text-slate-600">{{ $tx->supplier?->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-center font-semibold text-emerald-600">+{{ $tx->quantity }}</td>
                                <td class="px-6 py-3 text-right font-mono text-slate-700">Rp {{ number_format((float) $tx->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-slate-600 text-xs">{{ $tx->user?->name }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('stock-ins.edit', $tx) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit" data-testid="btn-edit-stockin-{{ $tx->id }}">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('stock-ins.destroy', $tx) }}" onsubmit="return confirm('Hapus transaksi? Stok akan dikembalikan.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus" data-testid="btn-delete-stockin-{{ $tx->id }}">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-slate-100">{{ $stockIns->links() }}</div>
        @endif
    </x-section-card>
</x-app-layout>
