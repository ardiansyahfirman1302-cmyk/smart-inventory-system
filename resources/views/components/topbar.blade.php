@props(['title' => 'Dashboard', 'subtitle' => null])

<header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-slate-200"
        data-testid="app-topbar">
    <div class="flex items-center gap-4 px-4 lg:px-8 h-16">
        <button
            @click="$dispatch('toggle-sidebar')"
            class="lg:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-700"
            data-testid="topbar-toggle-sidebar-btn"
        >
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div class="flex-1 min-w-0">
            <h1 class="text-lg font-semibold text-slate-900 truncate" data-testid="topbar-title">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-xs text-slate-500 truncate">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500 text-xs">
            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
            <span data-testid="topbar-date">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>

        <button class="relative p-2 rounded-lg hover:bg-slate-100 text-slate-600" data-testid="topbar-notifications-btn" title="Notifikasi">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
        </button>

        <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-slate-100" data-testid="topbar-profile-link">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold">
                {{ auth()->user()?->initials() ?? 'U' }}
            </div>
            <div class="text-left">
                <p class="text-xs font-semibold text-slate-800 leading-tight">{{ auth()->user()?->name }}</p>
                <p class="text-[10px] text-slate-500 leading-tight">{{ auth()->user()?->primaryRoleName() }}</p>
            </div>
        </a>
    </div>
</header>
