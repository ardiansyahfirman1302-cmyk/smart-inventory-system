@props(['category' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="category-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-input name="code" label="Kode Kategori" :value="$category?->code" required icon="hash" placeholder="mis. CAT-ELC" />
        <div class="md:col-span-2">
            <x-form-input name="name" label="Nama Kategori" :value="$category?->name" required icon="tag" placeholder="mis. Elektronik" />
        </div>
    </div>

    <x-form-textarea name="description" label="Deskripsi" :value="$category?->description" placeholder="Deskripsi singkat kategori..." rows="3" />

    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category?->is_active ?? true))
               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
               data-testid="checkbox-is-active">
        <span class="text-sm text-slate-700">Aktif</span>
    </label>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('categories.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-category">Simpan</x-btn>
    </div>
</form>
