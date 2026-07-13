<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(): View
    {
        $from = request('from') ? Carbon::parse(request('from')) : Carbon::now()->startOfMonth();
        $to   = request('to')   ? Carbon::parse(request('to'))   : Carbon::now()->endOfMonth();

        $totalIn      = StockIn::whereBetween('transaction_date', [$from, $to])->sum('quantity');
        $totalOut     = StockOut::whereBetween('transaction_date', [$from, $to])->sum('quantity');
        $totalInValue = StockIn::whereBetween('transaction_date', [$from, $to])->sum('total_price');
        $mntCount     = Maintenance::whereBetween('created_at', [$from, $to->copy()->endOfDay()])->count();

        // Top products by stock-out qty in period
        $topOut = StockOut::selectRaw('product_id, SUM(quantity) as total_qty')
            ->whereBetween('transaction_date', [$from, $to])
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product:id,name,sku')
            ->limit(5)
            ->get();

        // Stock by category
        $stockByCategory = Category::withSum('products as total_stock', 'stock')
            ->withCount('products')
            ->orderByDesc('total_stock')
            ->get();

        // Maintenance status distribution
        $maintenanceStatus = Maintenance::selectRaw('status, COUNT(*) as count')
            ->whereBetween('created_at', [$from, $to->copy()->endOfDay()])
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('reports.index', [
            'pageTitle' => 'Reports',
            'pageSubtitle' => 'Analisis performa inventory & maintenance',
            'from' => $from,
            'to' => $to,
            'totalIn' => (int) $totalIn,
            'totalOut' => (int) $totalOut,
            'totalInValue' => (float) $totalInValue,
            'mntCount' => (int) $mntCount,
            'topOut' => $topOut,
            'stockByCategory' => $stockByCategory,
            'maintenanceStatus' => $maintenanceStatus,
        ]);
    }
}
