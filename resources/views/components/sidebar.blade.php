@php
    $user = auth()->user();
    $roleName = $user?->primaryRoleName() ?? 'Staff';
    $modules = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'layout-dashboard', 'active' => request()->routeIs('dashboard')],
        ['label' => 'Master Barang', 'route' => 'products.index', 'icon' => 'package', 'active' => request()->routeIs('products.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('products.index')],
        ['label' => 'Kategori', 'route' => 'categories.index', 'icon' => 'tags', 'active' => request()->routeIs('categories.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('categories.index')],
        ['label' => 'Supplier', 'route' => 'suppliers.index', 'icon' => 'truck', 'active' => request()->routeIs('suppliers.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('suppliers.index')],
        ['label' => 'Lokasi Gudang', 'route' => 'locations.index', 'icon' => 'warehouse', 'active' => request()->routeIs('locations.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('locations.index')],
        ['label' => 'Barang Masuk', 'route' => 'stock-ins.index', 'icon' => 'arrow-down-to-line', 'active' => request()->routeIs('stock-ins.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('stock-ins.index')],
        ['label' => 'Barang Keluar', 'route' => 'stock-outs.index', 'icon' => 'arrow-up-from-line', 'active' => request()->routeIs('stock-outs.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('stock-outs.index')],
        ['label' => 'Maintenance', 'route' => 'maintenances.index', 'icon' => 'wrench', 'active' => request()->routeIs('maintenances.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('maintenances.index')],
        ['label' => 'Reports', 'route' => 'reports.index', 'icon' => 'file-bar-chart', 'active' => request()->routeIs('reports.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('reports.index')],
        ['label' => 'AI Recommendation', 'route' => 'ai.index', 'icon' => 'sparkles', 'active' => request()->routeIs('ai.*'), 'disabled' => !\Illuminate\Support\Facades\Route::has('ai.index')],
        ['label' => 'Settings', 'route' => 'profile.edit', 'icon' => 'settings', 'active' => request()->routeIs('profile.*')],
    ];
@endphp

<aside x-data="{ sidebarOpen: false }"
       @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-200 transform lg:translate-x-0 transition-transform duration-200 ease-in-out flex flex-col"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       data-testid="app-sidebar">

    {{-- Backdrop for mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition.opacity
         class="fixed inset-0 bg-black/50 lg:hidden -z-10"></div>

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-slate-800">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-fuchsia-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
            <i data-lucide="boxes" class="w-5 h-5 text-white"></i>
        </div>
        <div class="leading-tight">
            <p class="text-sm font-bold text-white">Smart Inventory</p>
            <p class="text-[10px] uppercase tracking-widest text-indigo-300">AI Platform</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" data-testid="sidebar-nav">
        <p class="px-3 text-[10px] uppercase tracking-wider text-slate-500 mb-2">Menu Utama</p>
        @foreach ($modules as $m)
            @php $disabled = $m['disabled'] ?? false; @endphp
            @if ($disabled)
                <span class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-500 cursor-not-allowed"
                      title="Segera hadir"
                      data-testid="sidebar-link-{{ Str::slug($m['label']) }}-disabled">
                    <i data-lucide="{{ $m['icon'] }}" class="w-4 h-4"></i>
                    <span class="flex-1">{{ $m['label'] }}</span>
                    <span class="text-[9px] uppercase px-1.5 py-0.5 rounded-full bg-slate-800 text-slate-400">soon</span>
                </span>
            @else
                <a href="{{ route($m['route']) }}"
                   data-testid="sidebar-link-{{ Str::slug($m['label']) }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
                        {{ $m['active'] ? 'bg-gradient-to-r from-indigo-600/90 to-indigo-500/70 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="{{ $m['icon'] }}" class="w-4 h-4"></i>
                    <span class="flex-1">{{ $m['label'] }}</span>
                    @if ($m['active'])
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    {{-- User card --}}
    <div class="mx-3 mb-4 p-3 rounded-xl bg-slate-800/70 border border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold">
                {{ $user?->initials() ?? 'U' }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-white truncate">{{ $user?->name ?? 'Guest' }}</p>
                <p class="text-[10px] text-slate-400 truncate">{{ $roleName }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Log out" data-testid="sidebar-logout-btn"
                    class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700 transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
