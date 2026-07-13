@props(['stockIn' => null, 'action', 'method' => 'POST', 'products', 'suppliers'])

@php
    $productOptions = $products->mapWithKeys(fn ($p) => [$p->id => "$p->name ($p->sku)"])->toArray();
@endphp

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="stockin-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form-select name="product_id" label="Barang" :options="$productOptions" :value="$stockIn?->product_id" required placeholder="-- Pilih Barang --" />
        <x-form-select name="supplier_id" label="Supplier" :options="$suppliers->toArray()" :value="$stockIn?->supplier_id" placeholder="-- Pilih Supplier --" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-input name="quantity" type="number" step="1" min="1" label="Jumlah" :value="$stockIn?->quantity" required icon="hash" />
        <x-form-input name="unit_price" type="number" step="1" min="0" label="Harga Satuan (Rp)" :value="$stockIn?->unit_price" required icon="banknote" />
        <x-form-input name="transaction_date" type="date" label="Tanggal Transaksi" :value="optional($stockIn?->transaction_date)->format('Y-m-d') ?? now()->toDateString()" required icon="calendar" />
    </div>

    <x-form-textarea name="notes" label="Catatan" :value="$stockIn?->notes" rows="2" placeholder="Catatan opsional..." />

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('stock-ins.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-stockin">Simpan Transaksi</x-btn>
    </div>
</form>
