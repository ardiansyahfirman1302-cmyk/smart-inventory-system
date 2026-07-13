<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockInRequest;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index(): View
    {
        $query = StockIn::with(['product:id,name,sku', 'supplier:id,name', 'user:id,name']);

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('reference_no', 'like', "%$q%")
                ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%$q%")->orWhere('sku', 'like', "%$q%")));
        }

        $stockIns = $query->latest('transaction_date')->latest('id')->paginate(10)->withQueryString();

        return view('stock-ins.index', [
            'pageTitle' => 'Barang Masuk',
            'pageSubtitle' => 'Riwayat transaksi penerimaan barang',
            'stockIns' => $stockIns,
        ]);
    }

    public function create(): View
    {
        return view('stock-ins.create', [
            'pageTitle' => 'Input Barang Masuk',
            'pageSubtitle' => 'Catat penerimaan barang baru',
            'products'  => Product::where('is_active', true)->orderBy('name')->get(['id', 'name', 'sku', 'unit', 'price']),
            'suppliers' => Supplier::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(StockInRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            $data['total_price'] = $data['quantity'] * $data['unit_price'];
            $data['reference_no'] = $this->generateRef();

            $stockIn = StockIn::create($data);
            Product::where('id', $data['product_id'])->increment('stock', $data['quantity']);

            return $stockIn;
        });

        return redirect()->route('stock-ins.index')->with('status', 'Transaksi Barang Masuk berhasil dicatat. Stok terupdate otomatis.');
    }

    public function edit(StockIn $stockIn): View
    {
        return view('stock-ins.edit', [
            'pageTitle' => 'Edit Barang Masuk',
            'pageSubtitle' => $stockIn->reference_no,
            'stockIn' => $stockIn->load('product'),
            'products'  => Product::where('is_active', true)->orderBy('name')->get(['id', 'name', 'sku', 'unit', 'price']),
            'suppliers' => Supplier::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function update(StockInRequest $request, StockIn $stockIn): RedirectResponse
    {
        DB::transaction(function () use ($request, $stockIn) {
            $original = $stockIn->only(['product_id', 'quantity']);
            $data = $request->validated();
            $data['total_price'] = $data['quantity'] * $data['unit_price'];

            // Revert old stock effect
            Product::where('id', $original['product_id'])->decrement('stock', $original['quantity']);

            $stockIn->update($data);

            // Apply new stock effect
            Product::where('id', $data['product_id'])->increment('stock', $data['quantity']);
        });

        return redirect()->route('stock-ins.index')->with('status', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(StockIn $stockIn): RedirectResponse
    {
        DB::transaction(function () use ($stockIn) {
            Product::where('id', $stockIn->product_id)->decrement('stock', $stockIn->quantity);
            $stockIn->delete();
        });

        return redirect()->route('stock-ins.index')->with('status', 'Transaksi dihapus & stok direvert.');
    }

    private function generateRef(): string
    {
        $prefix = 'IN-' . now()->format('ymd');
        $last = StockIn::where('reference_no', 'like', "$prefix%")->count() + 1;
        return $prefix . str_pad((string) $last, 3, '0', STR_PAD_LEFT);
    }
}
