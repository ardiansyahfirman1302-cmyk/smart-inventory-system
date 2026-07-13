<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    public function index(): View
    {
        $query = Supplier::query()->withCount('products');

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('code', 'like', "%$q%")
                ->orWhere('name', 'like', "%$q%")
                ->orWhere('contact_person', 'like', "%$q%")
                ->orWhere('email', 'like', "%$q%"));
        }

        $suppliers = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('suppliers.index', [
            'pageTitle' => 'Master Supplier',
            'pageSubtitle' => 'Kelola daftar supplier & pemasok',
            'suppliers' => $suppliers,
        ]);
    }

    public function create(): View
    {
        return view('suppliers.create', [
            'pageTitle' => 'Tambah Supplier',
            'pageSubtitle' => 'Registrasi supplier baru',
        ]);
    }

    public function store(SupplierRequest $request): RedirectResponse
    {
        Supplier::create($request->validated());
        return redirect()->route('suppliers.index')->with('status', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier): View
    {
        return view('suppliers.edit', [
            'pageTitle' => 'Edit Supplier',
            'pageSubtitle' => $supplier->name,
            'supplier' => $supplier,
        ]);
    }

    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validated());
        return redirect()->route('suppliers.index')->with('status', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        if ($supplier->products()->exists() || $supplier->stockIns()->exists()) {
            return redirect()->route('suppliers.index')
                ->with('status', 'Supplier tidak dapat dihapus karena masih memiliki data terkait.');
        }
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('status', 'Supplier berhasil dihapus.');
    }
}
