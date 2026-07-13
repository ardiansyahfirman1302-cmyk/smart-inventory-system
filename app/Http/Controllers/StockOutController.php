<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockOutRequest;
use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    public function index(): View
    {
        $query = StockOut::with(['product:id,name,sku', 'user:id,name']);

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('reference_no', 'like', "%$q%")
                ->orWhere('recipient', 'like', "%$q%")
                ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%$q%")->orWhere('sku', 'like', "%$q%")));
        }

        $stockOuts = $query->latest('transaction_date')->latest('id')->paginate(10)->withQueryString();

        return view('stock-outs.index', [
            'pageTitle' => 'Barang Keluar',
            'pageSubtitle' => 'Riwayat transaksi pengeluaran barang',
            'stockOuts' => $stockOuts,
        ]);
    }

    public function create(): View
    {
        return view('stock-outs.create', [
            'pageTitle' => 'Input Barang Keluar',
            'pageSubtitle' => 'Catat pengeluaran barang',
            'products' => Product::where('is_active', true)->where('stock', '>', 0)->orderBy('name')->get(['id', 'name', 'sku', 'unit', 'stock']),
        ]);
    }

    public function store(StockOutRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            $data['reference_no'] = $this->generateRef();

            StockOut::create($data);
            Product::where('id', $data['product_id'])->decrement('stock', $data['quantity']);
        });

        return redirect()->route('stock-outs.index')->with('status', 'Transaksi Barang Keluar berhasil dicatat. Stok terupdate otomatis.');
    }

    public function edit(StockOut $stockOut): View
    {
        return view('stock-outs.edit', [
            'pageTitle' => 'Edit Barang Keluar',
            'pageSubtitle' => $stockOut->reference_no,
            'stockOut' => $stockOut->load('product'),
            'products' => Product::where('is_active', true)->orderBy('name')->get(['id', 'name', 'sku', 'unit', 'stock']),
        ]);
    }

    public function update(StockOutRequest $request, StockOut $stockOut): RedirectResponse
    {
        DB::transaction(function () use ($request, $stockOut) {
            $original = $stockOut->only(['product_id', 'quantity']);
            $data = $request->validated();

            // Revert old stock effect
            Product::where('id', $original['product_id'])->increment('stock', $original['quantity']);

            $stockOut->update($data);

            // Apply new stock effect
            Product::where('id', $data['product_id'])->decrement('stock', $data['quantity']);
        });

        return redirect()->route('stock-outs.index')->with('status', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(StockOut $stockOut): RedirectResponse
    {
        DB::transaction(function () use ($stockOut) {
            Product::where('id', $stockOut->product_id)->increment('stock', $stockOut->quantity);
            $stockOut->delete();
        });

        return redirect()->route('stock-outs.index')->with('status', 'Transaksi dihapus & stok direvert.');
    }

    private function generateRef(): string
    {
        $prefix = 'OUT-' . now()->format('ymd');
        $last = StockOut::where('reference_no', 'like', "$prefix%")->count() + 1;
        return $prefix . str_pad((string) $last, 3, '0', STR_PAD_LEFT);
    }
}
