@props(['stockOut' => null, 'action', 'method' => 'POST', 'products'])

@php
    $productOptions = $products->mapWithKeys(fn ($p) => [$p->id => "$p->name ($p->sku) - stok: $p->stock $p->unit"])->toArray();
@endphp

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="stockout-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <x-form-select name="product_id" label="Barang" :options="$productOptions" :value="$stockOut?->product_id" required placeholder="-- Pilih Barang --" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form-input name="quantity" type="number" step="1" min="1" label="Jumlah Keluar" :value="$stockOut?->quantity" required icon="hash" />
        <x-form-input name="transaction_date" type="date" label="Tanggal Transaksi" :value="optional($stockOut?->transaction_date)->format('Y-m-d') ?? now()->toDateString()" required icon="calendar" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form-input name="recipient" label="Penerima" :value="$stockOut?->recipient" icon="user" placeholder="Nama penerima..." />
        <x-form-input name="purpose" label="Keperluan" :value="$stockOut?->purpose" icon="clipboard" placeholder="Untuk apa..." />
    </div>

    <x-form-textarea name="notes" label="Catatan" :value="$stockOut?->notes" rows="2" />

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('stock-outs.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-stockout">Simpan Transaksi</x-btn>
    </div>
</form>
