<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">
    <x-toolbar :title="$pageTitle" :subtitle="$pageSubtitle" :showSearch="false"
        :createUrl="route('maintenances.create')" createLabel="Buat Tiket" />

    <x-section-card padding="p-4" class="mb-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3" data-testid="mnt-filter-form">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i data-lucide="search" class="w-4 h-4"></i></span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari tiket/judul/barang..."
                    class="w-full pl-10 pr-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                    data-testid="mnt-filter-q" />
            </div>
            <select name="status" data-testid="mnt-filter-status" class="px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                <option value="">Semua Status</option>
                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $v => $l)
                    <option value="{{ $v }}" @selected(request('status')===$v)>{{ $l }}</option>
                @endforeach
            </select>
            <select name="priority" data-testid="mnt-filter-priority" class="px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                <option value="">Semua Prioritas</option>
                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'] as $v => $l)
                    <option value="{{ $v }}" @selected(request('priority')===$v)>{{ $l }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <x-btn type="submit" variant="primary" icon="filter">Terapkan</x-btn>
                <x-btn variant="secondary" :href="route('maintenances.index')" icon="rotate-ccw">Reset</x-btn>
            </div>
        </form>
    </x-section-card>

    <x-section-card padding="p-0">
        @if ($maintenances->isEmpty())
            <x-empty-state message="Belum ada tiket maintenance." icon="wrench" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" data-testid="maintenances-table">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold">Tiket</th>
                            <th class="text-left px-6 py-3 font-semibold">Judul</th>
                            <th class="text-left px-6 py-3 font-semibold">Barang/Aset</th>
                            <th class="text-center px-6 py-3 font-semibold">Prioritas</th>
                            <th class="text-center px-6 py-3 font-semibold">Status</th>
                            <th class="text-left px-6 py-3 font-semibold">Jadwal</th>
                            <th class="text-right px-6 py-3 font-semibold">Biaya</th>
                            <th class="text-right px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($maintenances as $m)
                            <tr class="hover:bg-slate-50" data-testid="row-maintenance-{{ $m->id }}">
                                <td class="px-6 py-3 font-mono text-xs text-slate-700">{{ $m->ticket_no }}</td>
                                <td class="px-6 py-3">
                                    <p class="font-medium text-slate-900">{{ $m->title }}</p>
                                    <p class="text-xs text-slate-500">{{ Str::limit($m->description, 40) }}</p>
                                </td>
                                <td class="px-6 py-3 text-slate-600">{{ $m->product?->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-center"><x-status-badge :status="$m->priority" /></td>
                                <td class="px-6 py-3 text-center"><x-status-badge :status="$m->status" /></td>
                                <td class="px-6 py-3 text-slate-600 text-xs">
                                    @if ($m->scheduled_at) <p>Jadwal: {{ $m->scheduled_at->translatedFormat('d M Y') }}</p> @endif
                                    @if ($m->completed_at) <p class="text-emerald-600">Selesai: {{ $m->completed_at->translatedFormat('d M Y') }}</p> @endif
                                </td>
                                <td class="px-6 py-3 text-right font-mono text-slate-700">Rp {{ number_format((float) $m->cost, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('maintenances.edit', $m) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit" data-testid="btn-edit-maintenance-{{ $m->id }}">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('maintenances.destroy', $m) }}" onsubmit="return confirm('Hapus tiket?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus" data-testid="btn-delete-maintenance-{{ $m->id }}">
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
            <div class="px-6 py-3 border-t border-slate-100">{{ $maintenances->links() }}</div>
        @endif
    </x-section-card>
</x-app-layout>
