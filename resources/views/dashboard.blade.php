<x-app-layout :pageTitle="$pageTitle" :pageSubtitle="$pageSubtitle">

    {{-- Row 1: KPI Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4" data-testid="stats-grid">
        <x-stat-card
            label="Total Barang"
            :value="number_format($stats['total_products']['value'])"
            icon="package"
            color="indigo"
            testid="stat-total-products" />

        <x-stat-card
            label="Total Supplier"
            :value="number_format($stats['total_suppliers']['value'])"
            icon="truck"
            color="sky"
            testid="stat-total-suppliers" />

        <x-stat-card
            label="Barang Masuk Hari Ini"
            :value="number_format($stats['in_today']['value'])"
            icon="arrow-down-to-line"
            color="emerald"
            :delta="$stats['in_today']['delta']"
            :deltaTone="$stats['in_today']['deltaTone']"
            testid="stat-in-today" />

        <x-stat-card
            label="Barang Keluar Hari Ini"
            :value="number_format($stats['out_today']['value'])"
            icon="arrow-up-from-line"
            color="violet"
            :delta="$stats['out_today']['delta']"
            :deltaTone="$stats['out_today']['deltaTone']"
            testid="stat-out-today" />

        <x-stat-card
            label="Low Stock"
            :value="number_format($stats['low_stock']['value'])"
            icon="alert-triangle"
            color="amber"
            :delta="$stats['low_stock']['delta']"
            :deltaTone="$stats['low_stock']['deltaTone']"
            testid="stat-low-stock" />

        <x-stat-card
            label="Out of Stock"
            :value="number_format($stats['out_of_stock']['value'])"
            icon="package-x"
            color="rose"
            :delta="$stats['out_of_stock']['delta']"
            :deltaTone="$stats['out_of_stock']['deltaTone']"
            testid="stat-out-of-stock" />
    </div>

    {{-- Row 2: Chart (2/3) + AI Card (1/3) --}}
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Monthly Chart --}}
        <x-section-card
            class="xl:col-span-2"
            title="Pergerakan Stok Bulanan"
            subtitle="6 bulan terakhir - Barang Masuk vs Keluar"
            icon="line-chart"
            data-testid="chart-card">
            <x-slot name="action">
                <div class="flex items-center gap-3 text-xs text-slate-600">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Masuk
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span> Keluar
                    </span>
                </div>
            </x-slot>

            <div class="h-72">
                <canvas id="monthlyChart" data-testid="monthly-chart"></canvas>
            </div>
        </x-section-card>

        {{-- AI Recommendation --}}
        <div class="xl:col-span-1">
            <x-ai-card :recommendations="$recommendations" />
        </div>
    </div>

    {{-- Row 3: Quick Actions --}}
    <div class="mt-6" data-testid="quick-actions-row">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider">Quick Actions</h2>
            <span class="text-xs text-slate-500">Akses cepat ke transaksi utama</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            <x-quick-action label="Tambah Barang"    icon="plus-square"       color="indigo"  href="{{ Route::has('products.create') ? route('products.create') : '#' }}"       testid="qa-add-product" />
            <x-quick-action label="Barang Masuk"     icon="arrow-down-to-line" color="emerald" href="{{ Route::has('stock-ins.create') ? route('stock-ins.create') : '#' }}"    testid="qa-stock-in" />
            <x-quick-action label="Barang Keluar"    icon="arrow-up-from-line" color="amber"   href="{{ Route::has('stock-outs.create') ? route('stock-outs.create') : '#' }}"  testid="qa-stock-out" />
            <x-quick-action label="Buat Maintenance" icon="wrench"             color="rose"    href="{{ Route::has('maintenances.create') ? route('maintenances.create') : '#' }}" testid="qa-maintenance" />
            <x-quick-action label="Lihat Laporan"    icon="file-bar-chart"     color="sky"     href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}"         testid="qa-reports" />
        </div>
    </div>

    {{-- Row 4: Recent Activity (2 columns) + Low Stock --}}
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Recent Stock In --}}
        <x-section-card
            title="Transaksi Barang Masuk Terkini"
            icon="arrow-down-to-line"
            padding="p-0"
            class="xl:col-span-1"
            data-testid="recent-in-card">
            <div class="divide-y divide-slate-100" data-testid="recent-in-list">
                @forelse ($recentIn as $tx)
                    <div class="flex items-center gap-3 px-6 py-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i data-lucide="arrow-down-right" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $tx->product?->name ?? '-' }}</p>
                            <p class="text-xs text-slate-500 truncate">
                                {{ $tx->reference_no }} · {{ $tx->supplier?->name ?? 'Tanpa supplier' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-emerald-600">+{{ $tx->quantity }}</p>
                            <p class="text-[10px] text-slate-400">{{ optional($tx->transaction_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada transaksi masuk.</div>
                @endforelse
            </div>
        </x-section-card>

        {{-- Recent Stock Out --}}
        <x-section-card
            title="Transaksi Barang Keluar Terkini"
            icon="arrow-up-from-line"
            padding="p-0"
            class="xl:col-span-1"
            data-testid="recent-out-card">
            <div class="divide-y divide-slate-100" data-testid="recent-out-list">
                @forelse ($recentOut as $tx)
                    <div class="flex items-center gap-3 px-6 py-3">
                        <div class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                            <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $tx->product?->name ?? '-' }}</p>
                            <p class="text-xs text-slate-500 truncate">
                                {{ $tx->reference_no }} · {{ $tx->purpose ?? 'Umum' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-violet-600">-{{ $tx->quantity }}</p>
                            <p class="text-[10px] text-slate-400">{{ optional($tx->transaction_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada transaksi keluar.</div>
                @endforelse
            </div>
        </x-section-card>

        {{-- Low Stock List --}}
        <x-section-card
            title="Perhatian: Stok Menipis"
            subtitle="Barang dengan stok ≤ minimum"
            icon="alert-triangle"
            padding="p-0"
            class="xl:col-span-1"
            data-testid="low-stock-card">
            <div class="divide-y divide-slate-100" data-testid="low-stock-list">
                @forelse ($lowStockList as $prod)
                    @php
                        $pct = $prod->min_stock > 0 ? min(100, round(($prod->stock / max($prod->min_stock, 1)) * 100)) : 0;
                        $isOut = $prod->stock <= 0;
                    @endphp
                    <div class="px-6 py-3">
                        <div class="flex items-center justify-between mb-1.5">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $prod->name }}</p>
                            <span class="text-xs font-semibold {{ $isOut ? 'text-rose-600' : 'text-amber-600' }}">
                                {{ $prod->stock }} / {{ $prod->min_stock }}
                            </span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full {{ $isOut ? 'bg-rose-500' : 'bg-amber-500' }}" style="width: {{ $pct }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-1">{{ $prod->category?->name }} · {{ $prod->location?->name ?? 'Tanpa lokasi' }}</p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400">Semua stok aman. 🎉</div>
                @endforelse
            </div>
        </x-section-card>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('load', () => {
            if (typeof Chart === 'undefined') return;
            const ctx = document.getElementById('monthlyChart');
            if (!ctx) return;

            const chartData = @json($chart);

            const gradientIn = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
            gradientIn.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
            gradientIn.addColorStop(1, 'rgba(16, 185, 129, 0.02)');

            const gradientOut = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
            gradientOut.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
            gradientOut.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Barang Masuk',
                            data: chartData.in,
                            borderColor: '#10b981',
                            backgroundColor: gradientIn,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#10b981',
                            pointHoverRadius: 6,
                            borderWidth: 2,
                        },
                        {
                            label: 'Barang Keluar',
                            data: chartData.out,
                            borderColor: '#6366f1',
                            backgroundColor: gradientOut,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#6366f1',
                            pointHoverRadius: 6,
                            borderWidth: 2,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 11 } } },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(148,163,184,0.15)' },
                            ticks: { color: '#64748b', font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
