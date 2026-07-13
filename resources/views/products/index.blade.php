<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <x-toolbar :title="$pageTitle" :subtitle="$pageSubtitle" :showSearch="false"
        :createUrl="route('products.create')" createLabel="Tambah Barang" />

    {{-- Filter Bar --}}
    <x-section-card padding="p-4" class="mb-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3" data-testid="filter-form">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i data-lucide="search" class="w-4 h-4"></i></span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari SKU atau nama..."
                    data-testid="filter-q"
                    class="w-full pl-10 pr-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none" />
            </div>
            <select name="category_id" data-testid="filter-category" class="px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $id => $name)
                    <option value="{{ $id }}" @selected(request('category_id') == $id)>{{ $name }}</option>
                @endforeach
            </select>
            <select name="status" data-testid="filter-status" class="px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                <option value="">Semua Status Stok</option>
                <option value="ok"  @selected(request('status')==='ok')>Stok Aman</option>
                <option value="low" @selected(request('status')==='low')>Low Stock</option>
                <option value="out" @selected(request('status')==='out')>Out of Stock</option>
            </select>
            <div class="flex gap-2">
                <x-btn type="submit" variant="primary" icon="filter" data-testid="btn-apply-filter">Terapkan</x-btn>
                <x-btn variant="secondary" :href="route('products.index')" icon="rotate-ccw" data-testid="btn-reset-filter">Reset</x-btn>
            </div>
        </form>
    </x-section-card>

    <x-section-card padding="p-0">
        @if ($products->isEmpty())
            <x-empty-state message="Belum ada barang. Tambahkan barang pertama Anda." icon="package" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" data-testid="products-table">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">SKU</th>
                            <th class="text-left px-6 py-3 font-semibold">Nama Barang</th>
                            <th class="text-left px-6 py-3 font-semibold">Kategori</th>
                            <th class="text-left px-6 py-3 font-semibold">Lokasi</th>
                            <th class="text-right px-6 py-3 font-semibold">Harga</th>
                            <th class="text-center px-6 py-3 font-semibold">Stok</th>
                            <th class="text-center px-6 py-3 font-semibold">Status</th>
                            <th class="text-right px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($products as $p)
                            <tr class="hover:bg-slate-50" data-testid="row-product-{{ $p->id }}">
                                <td class="px-6 py-3 font-mono text-xs text-slate-700">{{ $p->sku }}</td>
                                <td class="px-6 py-3 font-medium text-slate-900">{{ $p->name }}</td>
                                <td class="px-6 py-3 text-slate-600">{{ $p->category?->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-slate-500 text-xs">{{ $p->location?->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-right font-mono text-slate-700">Rp {{ number_format((float) $p->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-center">
                                    <span class="font-semibold text-slate-800">{{ $p->stock }}</span>
                                    <span class="text-xs text-slate-400"> / min {{ $p->min_stock }}</span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <x-status-badge :status="$p->status" />
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('products.edit', $p) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit" data-testid="btn-edit-product-{{ $p->id }}">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('products.destroy', $p) }}" onsubmit="return confirm('Hapus barang ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus" data-testid="btn-delete-product-{{ $p->id }}">
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
            <div class="px-6 py-3 border-t border-slate-100">{{ $products->links() }}</div>
        @endif
    </x-section-card>
</x-app-layout>
