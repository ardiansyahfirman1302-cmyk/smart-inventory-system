<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <x-toolbar :title="$pageTitle" :subtitle="$pageSubtitle" searchPlaceholder="Cari lokasi..."
        :createUrl="route('locations.create')" createLabel="Tambah Lokasi" />

    <x-section-card padding="p-0">
        @if ($locations->isEmpty())
            <x-empty-state message="Belum ada lokasi gudang." icon="warehouse" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" data-testid="locations-table">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">Kode</th>
                            <th class="text-left px-6 py-3 font-semibold">Nama Lokasi</th>
                            <th class="text-left px-6 py-3 font-semibold">Alamat</th>
                            <th class="text-left px-6 py-3 font-semibold">PIC</th>
                            <th class="text-center px-6 py-3 font-semibold">Barang</th>
                            <th class="text-center px-6 py-3 font-semibold">Status</th>
                            <th class="text-right px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($locations as $loc)
                            <tr class="hover:bg-slate-50" data-testid="row-location-{{ $loc->id }}">
                                <td class="px-6 py-3 font-mono text-xs text-slate-700">{{ $loc->code }}</td>
                                <td class="px-6 py-3 font-medium text-slate-900">{{ $loc->name }}</td>
                                <td class="px-6 py-3 text-slate-500">{{ Str::limit($loc->address, 60) ?: '-' }}</td>
                                <td class="px-6 py-3 text-slate-700">{{ $loc->pic_name ?: '-' }}</td>
                                <td class="px-6 py-3 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">{{ $loc->products_count }}</span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <x-status-badge :status="$loc->is_active ? 'active' : 'inactive'" />
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('locations.edit', $loc) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit" data-testid="btn-edit-location-{{ $loc->id }}">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('locations.destroy', $loc) }}" onsubmit="return confirm('Hapus lokasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus" data-testid="btn-delete-location-{{ $loc->id }}">
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
            <div class="px-6 py-3 border-t border-slate-100">{{ $locations->links() }}</div>
        @endif
    </x-section-card>
</x-app-layout>
