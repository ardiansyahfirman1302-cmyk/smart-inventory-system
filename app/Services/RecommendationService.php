<?php

namespace App\Services;

use App\Models\Maintenance;
use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Support\Carbon;

class RecommendationService
{
    /**
     * Generate rule-based recommendations from current inventory data.
     *
     * @return array<int, array{tone:string,title:string,message:string}>
     */
    public function generate(): array
    {
        $recs = [];

        $outOfStock = Product::outOfStock()->count();
        if ($outOfStock > 0) {
            $recs[] = [
                'tone' => 'critical',
                'title' => "$outOfStock barang habis stok",
                'message' => 'Segera lakukan pemesanan ulang untuk menghindari terputusnya operasional.',
            ];
        }

        $lowStock = Product::lowStock()->count();
        if ($lowStock > 0) {
            $recs[] = [
                'tone' => 'warning',
                'title' => "$lowStock barang mendekati minimum",
                'message' => 'Barang berikut memiliki stok di bawah atau sama dengan ambang minimum. Rencanakan pengadaan.',
            ];
        }

        // Fast movers - top consumed in last 30 days
        $fastMover = StockOut::query()
            ->selectRaw('product_id, SUM(quantity) as qty')
            ->where('transaction_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->with('product:id,name')
            ->first();

        if ($fastMover && $fastMover->product) {
            $recs[] = [
                'tone' => 'info',
                'title' => "'{$fastMover->product->name}' adalah barang tercepat keluar",
                'message' => "Total {$fastMover->qty} unit keluar dalam 30 hari terakhir. Pertimbangkan meningkatkan safety stock.",
            ];
        }

        // Dead stock - no movement in 90 days but stock > 0
        $deadStockCount = Product::where('stock', '>', 0)
            ->whereDoesntHave('stockOuts', fn ($q) => $q->where('transaction_date', '>=', Carbon::now()->subDays(90)))
            ->count();

        if ($deadStockCount > 0) {
            $recs[] = [
                'tone' => 'info',
                'title' => "$deadStockCount barang stagnan (>90 hari)",
                'message' => 'Barang berikut belum pernah keluar dalam 90 hari terakhir. Evaluasi promosi atau relokasi.',
            ];
        }

        // Pending high-priority maintenance
        $urgentMaint = Maintenance::whereIn('status', ['pending', 'in_progress'])
            ->whereIn('priority', ['high', 'urgent'])
            ->count();
        if ($urgentMaint > 0) {
            $recs[] = [
                'tone' => 'warning',
                'title' => "$urgentMaint tiket maintenance prioritas tinggi",
                'message' => 'Segera tinjau tiket maintenance yang menunggu untuk mencegah gangguan operasional.',
            ];
        }

        if (empty($recs)) {
            $recs[] = [
                'tone' => 'success',
                'title' => 'Semua indikator sehat',
                'message' => 'Tidak ada aksi mendesak dari sistem. Inventory dalam kondisi terkendali.',
            ];
        }

        return array_slice($recs, 0, 4);
    }
}
