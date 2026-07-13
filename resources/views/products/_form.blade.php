@props(['product' => null, 'action', 'method' => 'POST', 'categories', 'suppliers', 'locations'])

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="product-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-input name="sku" label="SKU" :value="$product?->sku" required icon="hash" placeholder="mis. PRD-0001" />
        <div class="md:col-span-2">
            <x-form-input name="name" label="Nama Barang" :value="$product?->name" required icon="package" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-select name="category_id" label="Kategori" :options="$categories->toArray()" :value="$product?->category_id" required />
        <x-form-select name="supplier_id" label="Supplier" :options="$suppliers->toArray()" :value="$product?->supplier_id" />
        <x-form-select name="location_id" label="Lokasi Gudang" :options="$locations->toArray()" :value="$product?->location_id" />
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <x-form-input name="unit" label="Satuan" :value="$product?->unit ?? 'pcs'" required placeholder="pcs, unit, box, kg" />
        <x-form-input name="price" label="Harga (Rp)" type="number" step="1" min="0" :value="$product?->price" required />
        <x-form-input name="stock" label="Stok Saat Ini" type="number" step="1" min="0" :value="$product?->stock ?? 0" required />
        <x-form-input name="min_stock" label="Stok Minimum" type="number" step="1" min="0" :value="$product?->min_stock ?? 0" required help="Ambang batas alert" />
    </div>

    <x-form-textarea name="description" label="Deskripsi" :value="$product?->description" rows="3" />

    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product?->is_active ?? true))
               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" data-testid="checkbox-is-active">
        <span class="text-sm text-slate-700">Aktif</span>
    </label>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('products.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-product">Simpan</x-btn>
    </div>
</form>
