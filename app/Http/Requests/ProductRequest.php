<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $id = $this->route('product')?->id;

        return [
            'sku'         => ['required', 'string', 'max:30', Rule::unique('products', 'sku')->ignore($id)],
            'name'        => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'unit'        => ['required', 'string', 'max:20'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'min_stock'   => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function attributes(): array
    {
        return [
            'sku' => 'SKU', 'name' => 'Nama Barang', 'category_id' => 'Kategori',
            'supplier_id' => 'Supplier', 'location_id' => 'Lokasi', 'unit' => 'Satuan',
            'price' => 'Harga', 'stock' => 'Stok', 'min_stock' => 'Stok Minimum',
            'description' => 'Deskripsi', 'is_active' => 'Status Aktif',
        ];
    }
}
