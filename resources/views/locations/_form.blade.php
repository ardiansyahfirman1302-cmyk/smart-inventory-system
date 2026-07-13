@props(['location' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="location-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-input name="code" label="Kode Lokasi" :value="$location?->code" required icon="hash" placeholder="mis. GDG-A" />
        <div class="md:col-span-2">
            <x-form-input name="name" label="Nama Lokasi" :value="$location?->name" required icon="warehouse" placeholder="mis. Gudang A - Pusat" />
        </div>
    </div>

    <x-form-input name="pic_name" label="Penanggung Jawab" :value="$location?->pic_name" icon="user" />
    <x-form-textarea name="address" label="Alamat / Detail Lokasi" :value="$location?->address" rows="3" />

    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $location?->is_active ?? true))
               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" data-testid="checkbox-is-active">
        <span class="text-sm text-slate-700">Aktif</span>
    </label>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('locations.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-location">Simpan</x-btn>
    </div>
</form>
