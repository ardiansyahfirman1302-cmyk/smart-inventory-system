<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'product_id'       => ['required', 'exists:products,id'],
            'supplier_id'      => ['nullable', 'exists:suppliers,id'],
            'quantity'         => ['required', 'integer', 'min:1'],
            'unit_price'       => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Barang', 'supplier_id' => 'Supplier',
            'quantity' => 'Jumlah', 'unit_price' => 'Harga Satuan',
            'transaction_date' => 'Tanggal Transaksi', 'notes' => 'Catatan',
        ];
    }
}
