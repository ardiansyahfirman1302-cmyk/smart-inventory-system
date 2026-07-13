@props(['recommendations' => []])

<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 text-white p-6 border border-indigo-900/50"
     data-testid="ai-recommendation-card">

    {{-- Decorative glow --}}
    <div class="absolute -top-16 -right-16 w-52 h-52 rounded-full bg-fuchsia-500/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-10 w-52 h-52 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

    <div class="relative">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 backdrop-blur flex items-center justify-center">
                <i data-lucide="sparkles" class="w-5 h-5 text-fuchsia-300"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-fuchsia-300">Smart Inventory AI</p>
                <h3 class="text-base font-semibold">Rekomendasi Otomatis</h3>
            </div>
        </div>

        @if (empty($recommendations))
            <div class="rounded-xl bg-white/5 border border-white/10 p-4 text-sm text-slate-300">
                Belum ada rekomendasi. Data inventory Anda tampak sehat.
            </div>
        @else
            <ul class="space-y-3">
                @foreach ($recommendations as $rec)
                    @php
                        $toneMap = [
                            'critical' => ['bg' => 'bg-rose-500/15', 'border' => 'border-rose-400/30', 'text' => 'text-rose-200', 'icon' => 'alert-triangle'],
                            'warning'  => ['bg' => 'bg-amber-500/15', 'border' => 'border-amber-400/30', 'text' => 'text-amber-200', 'icon' => 'alert-circle'],
                            'info'     => ['bg' => 'bg-sky-500/15', 'border' => 'border-sky-400/30', 'text' => 'text-sky-200', 'icon' => 'info'],
                            'success'  => ['bg' => 'bg-emerald-500/15', 'border' => 'border-emerald-400/30', 'text' => 'text-emerald-200', 'icon' => 'check-circle-2'],
                        ];
                        $t = $toneMap[$rec['tone'] ?? 'info'] ?? $toneMap['info'];
                    @endphp
                    <li class="flex gap-3 rounded-xl {{ $t['bg'] }} border {{ $t['border'] }} p-3">
                        <div class="shrink-0 mt-0.5 {{ $t['text'] }}">
                            <i data-lucide="{{ $t['icon'] }}" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium leading-snug">{{ $rec['title'] }}</p>
                            <p class="text-xs text-slate-300 mt-0.5 leading-relaxed">{{ $rec['message'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-5 flex items-center justify-between text-xs">
            <span class="text-slate-400">Dianalisa dari data stok & transaksi terkini</span>
            <span class="inline-flex items-center gap-1 text-fuchsia-300">
                <i data-lucide="zap" class="w-3 h-3"></i>
                Rule-based AI
            </span>
        </div>
    </div>
</div>
