<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Supplier;
use App\Services\RecommendationService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(private readonly RecommendationService $recommender) {}

    public function index(): View
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $stats = $this->buildStats($today, $yesterday);
        $recentIn = $this->recentStockIns();
        $recentOut = $this->recentStockOuts();
        $chart = $this->monthlyChart();
        $lowStockList = Product::lowStock()->with(['category:id,name', 'location:id,name'])->orderBy('stock')->limit(5)->get();
        $recommendations = $this->recommender->generate();

        return view('dashboard', [
            'pageTitle'      => 'Dashboard',
            'pageSubtitle'   => 'Ringkasan performa inventory hari ini',
            'stats'          => $stats,
            'recentIn'       => $recentIn,
            'recentOut'      => $recentOut,
            'chart'          => $chart,
            'lowStockList'   => $lowStockList,
            'recommendations'=> $recommendations,
        ]);
    }

    /**
     * @return array<string, array{value:int|string, delta:string|null, deltaTone:string}>
     */
    private function buildStats(Carbon $today, Carbon $yesterday): array
    {
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();

        $inToday = StockIn::whereDate('transaction_date', $today)->sum('quantity');
        $inYesterday = StockIn::whereDate('transaction_date', $yesterday)->sum('quantity');

        $outToday = StockOut::whereDate('transaction_date', $today)->sum('quantity');
        $outYesterday = StockOut::whereDate('transaction_date', $yesterday)->sum('quantity');

        $lowStock = Product::lowStock()->count();
        $outOfStock = Product::outOfStock()->count();

        return [
            'total_products'   => ['value' => $totalProducts, 'delta' => null, 'deltaTone' => 'neutral'],
            'total_suppliers'  => ['value' => $totalSuppliers, 'delta' => null, 'deltaTone' => 'neutral'],
            'in_today'         => [
                'value'     => (int) $inToday,
                'delta'     => $this->formatDelta($inToday, $inYesterday),
                'deltaTone' => $this->trend($inToday, $inYesterday),
            ],
            'out_today'        => [
                'value'     => (int) $outToday,
                'delta'     => $this->formatDelta($outToday, $outYesterday),
                'deltaTone' => $this->trend($outToday, $outYesterday, invert: true),
            ],
            'low_stock'        => [
                'value'     => $lowStock,
                'delta'     => $lowStock > 0 ? 'Perlu tindakan' : 'Aman',
                'deltaTone' => $lowStock > 0 ? 'negative' : 'positive',
            ],
            'out_of_stock'     => [
                'value'     => $outOfStock,
                'delta'     => $outOfStock > 0 ? 'Prioritas' : 'Aman',
                'deltaTone' => $outOfStock > 0 ? 'negative' : 'positive',
            ],
        ];
    }

    private function recentStockIns()
    {
        return StockIn::with(['product:id,name,sku', 'supplier:id,name', 'user:id,name'])
            ->latest('transaction_date')
            ->latest('id')
            ->limit(5)
            ->get();
    }

    private function recentStockOuts()
    {
        return StockOut::with(['product:id,name,sku', 'user:id,name'])
            ->latest('transaction_date')
            ->latest('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return array{labels: array<int,string>, in: array<int,int>, out: array<int,int>}
     */
    private function monthlyChart(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->startOfMonth()->subMonths($i));

        $labels = $months->map(fn (Carbon $d) => $d->translatedFormat('M Y'))->all();

        $inTotals = $months->map(function (Carbon $d) {
            return (int) StockIn::whereBetween('transaction_date', [$d->copy()->startOfMonth(), $d->copy()->endOfMonth()])->sum('quantity');
        })->all();

        $outTotals = $months->map(function (Carbon $d) {
            return (int) StockOut::whereBetween('transaction_date', [$d->copy()->startOfMonth(), $d->copy()->endOfMonth()])->sum('quantity');
        })->all();

        return ['labels' => $labels, 'in' => $inTotals, 'out' => $outTotals];
    }

    private function formatDelta(int|float $current, int|float $previous): ?string
    {
        if ($previous == 0 && $current == 0) return 'Stabil';
        if ($previous == 0) return "+{$current} vs kemarin";
        $diff = $current - $previous;
        $sign = $diff > 0 ? '+' : '';
        return "{$sign}{$diff} vs kemarin";
    }

    private function trend(int|float $current, int|float $previous, bool $invert = false): string
    {
        if ($current == $previous) return 'neutral';
        $up = $current > $previous;
        return $invert ? ($up ? 'negative' : 'positive') : ($up ? 'positive' : 'negative');
    }
}
