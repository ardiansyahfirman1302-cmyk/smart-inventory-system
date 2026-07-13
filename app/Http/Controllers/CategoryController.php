<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function index(): View
    {
        $query = Category::query()->withCount('products');

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('code', 'like', "%$q%")->orWhere('name', 'like', "%$q%"));
        }

        $categories = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('categories.index', [
            'pageTitle' => 'Master Kategori',
            'pageSubtitle' => 'Kelola kategori barang untuk pengelompokan inventaris',
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        return view('categories.create', [
            'pageTitle' => 'Tambah Kategori',
            'pageSubtitle' => 'Buat kategori baru',
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', [
            'pageTitle' => 'Edit Kategori',
            'pageSubtitle' => $category->name,
            'category' => $category,
        ]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')
                ->with('status', 'Kategori tidak dapat dihapus karena masih memiliki barang terkait.');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Kategori berhasil dihapus.');
    }
}
