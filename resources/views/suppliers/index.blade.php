<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <x-toolbar
        :title="$pageTitle"
        :subtitle="$pageSubtitle"
        searchPlaceholder="Cari kode, nama, kontak..."
        :createUrl="route('suppliers.create')"
        createLabel="Tambah Supplier" />

    <x-section-card padding="p-0">
        @if ($suppliers->isEmpty())
            <x-empty-state message="Belum ada supplier." icon="truck" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" data-testid="suppliers-table">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">Kode</th>
                            <th class="text-left px-6 py-3 font-semibold">Nama Supplier</th>
                            <th class="text-left px-6 py-3 font-semibold">Kontak</th>
                            <th class="text-left px-6 py-3 font-semibold">Telepon / Email</th>
                            <th class="text-center px-6 py-3 font-semibold">Barang</th>
                            <th class="text-center px-6 py-3 font-semibold">Status</th>
                            <th class="text-right px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($suppliers as $sup)
                            <tr class="hover:bg-slate-50" data-testid="row-supplier-{{ $sup->id }}">
                                <td class="px-6 py-3 font-mono text-xs text-slate-700">{{ $sup->code }}</td>
                                <td class="px-6 py-3 font-medium text-slate-900">
                                    {{ $sup->name }}
                                    @if ($sup->address)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ Str::limit($sup->address, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-slate-700">{{ $sup->contact_person ?: '-' }}</td>
                                <td class="px-6 py-3 text-slate-500 text-xs">
                                    <p>{{ $sup->phone ?: '—' }}</p>
                                    <p>{{ $sup->email ?: '' }}</p>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">{{ $sup->products_count }}</span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <x-status-badge :status="$sup->is_active ? 'active' : 'inactive'" />
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('suppliers.edit', $sup) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit" data-testid="btn-edit-supplier-{{ $sup->id }}">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('suppliers.destroy', $sup) }}" onsubmit="return confirm('Hapus supplier ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus" data-testid="btn-delete-supplier-{{ $sup->id }}">
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
            <div class="px-6 py-3 border-t border-slate-100">{{ $suppliers->links() }}</div>
        @endif
    </x-section-card>
</x-app-layout>
