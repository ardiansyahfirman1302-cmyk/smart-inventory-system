<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\RecommendationService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class AiRecommendationController extends Controller
{
    public function __construct(private readonly RecommendationService $recommender) {}

    public function index(): View
    {
        $recommendations = $this->recommender->generate();

        $lowStock = Product::lowStock()->with(['category:id,name', 'supplier:id,name', 'location:id,name'])->orderBy('stock')->get();
        $outOfStock = Product::outOfStock()->with(['category:id,name', 'supplier:id,name'])->get();

        $deadStock = Product::where('stock', '>', 0)
            ->whereDoesntHave('stockOuts', fn ($q) => $q->where('transaction_date', '>=', Carbon::now()->subDays(90)))
            ->with(['category:id,name'])
            ->limit(10)->get();

        return view('ai.index', [
            'pageTitle' => 'AI Recommendation',
            'pageSubtitle' => 'Rekomendasi otomatis berbasis analisis data inventory',
            'recommendations' => $recommendations,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock,
            'deadStock' => $deadStock,
        ]);
    }
}
