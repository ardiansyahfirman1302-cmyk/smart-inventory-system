<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(): View
    {
        $query = Product::query()->with(['category:id,name', 'supplier:id,name', 'location:id,name']);

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('sku', 'like', "%$q%")->orWhere('name', 'like', "%$q%"));
        }

        if ($cat = request('category_id')) {
            $query->where('category_id', $cat);
        }

        if ($status = request('status')) {
            match ($status) {
                'low'  => $query->lowStock(),
                'out'  => $query->outOfStock(),
                'ok'   => $query->whereColumn('stock', '>', 'min_stock'),
                default => null,
            };
        }

        $products = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('products.index', [
            'pageTitle' => 'Master Barang',
            'pageSubtitle' => 'Kelola master data barang & aset inventaris',
            'products' => $products,
            'categories' => Category::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function create(): View
    {
        return view('products.create', [
            'pageTitle' => 'Tambah Barang',
            'pageSubtitle' => 'Registrasi barang baru',
            'categories' => Category::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
            'suppliers'  => Supplier::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
            'locations'  => Location::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('status', 'Barang berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('products.edit', [
            'pageTitle' => 'Edit Barang',
            'pageSubtitle' => $product->name,
            'product' => $product,
            'categories' => Category::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
            'suppliers'  => Supplier::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
            'locations'  => Location::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->stockIns()->exists() || $product->stockOuts()->exists() || $product->maintenances()->exists()) {
            return redirect()->route('products.index')
                ->with('status', 'Barang tidak dapat dihapus karena memiliki transaksi/maintenance terkait.');
        }
        $product->delete();
        return redirect()->route('products.index')->with('status', 'Barang berhasil dihapus.');
    }
}
