@props(['supplier' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="supplier-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-input name="code" label="Kode Supplier" :value="$supplier?->code" required icon="hash" placeholder="mis. SUP-001" />
        <div class="md:col-span-2">
            <x-form-input name="name" label="Nama Supplier" :value="$supplier?->name" required icon="building-2" placeholder="mis. PT Sumber Makmur" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form-input name="contact_person" label="Kontak Person" :value="$supplier?->contact_person" icon="user" />
        <x-form-input name="phone" label="Telepon" :value="$supplier?->phone" icon="phone" placeholder="0812-3456-7890" />
    </div>

    <x-form-input name="email" type="email" label="Email" :value="$supplier?->email" icon="mail" placeholder="supplier@company.com" />

    <x-form-textarea name="address" label="Alamat" :value="$supplier?->address" rows="3" />

    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $supplier?->is_active ?? true))
               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" data-testid="checkbox-is-active">
        <span class="text-sm text-slate-700">Aktif</span>
    </label>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('suppliers.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-supplier">Simpan</x-btn>
    </div>
</form>
