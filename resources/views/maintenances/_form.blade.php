@props(['maintenance' => null, 'action', 'method' => 'POST', 'products'])

<form method="POST" action="{{ $action }}" class="space-y-5" data-testid="maintenance-form">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form-select name="product_id" label="Barang / Aset" :options="$products->toArray()" :value="$maintenance?->product_id" required />
        <x-form-input name="title" label="Judul Tiket" :value="$maintenance?->title" required icon="clipboard-list" placeholder="mis. Servis rutin printer" />
    </div>

    <x-form-textarea name="description" label="Deskripsi Masalah / Servis" :value="$maintenance?->description" rows="3" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-select name="status" label="Status" :value="$maintenance?->status ?? 'pending'" required
            :options="['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled']" />
        <x-form-select name="priority" label="Prioritas" :value="$maintenance?->priority ?? 'medium'" required
            :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent']" />
        <x-form-input name="cost" type="number" step="1" min="0" label="Biaya (Rp)" :value="$maintenance?->cost ?? 0" icon="banknote" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form-input name="scheduled_at" type="date" label="Tanggal Dijadwalkan" :value="optional($maintenance?->scheduled_at)->format('Y-m-d')" icon="calendar" />
        <x-form-input name="completed_at" type="date" label="Tanggal Selesai" :value="optional($maintenance?->completed_at)->format('Y-m-d')" icon="calendar-check" help="Diisi otomatis jika status Completed" />
    </div>

    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
        <x-btn variant="secondary" :href="route('maintenances.index')" icon="x">Batal</x-btn>
        <x-btn type="submit" variant="primary" icon="save" data-testid="btn-save-maintenance">Simpan</x-btn>
    </div>
</form>
