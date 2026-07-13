<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StockOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'product_id'       => ['required', 'exists:products,id'],
            'quantity'         => ['required', 'integer', 'min:1'],
            'recipient'        => ['nullable', 'string', 'max:150'],
            'purpose'          => ['nullable', 'string', 'max:150'],
            'transaction_date' => ['required', 'date'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $product = Product::find($this->input('product_id'));
            $qty = (int) $this->input('quantity');
            if ($product && $qty > $product->stock) {
                $v->errors()->add('quantity', "Stok tidak mencukupi. Sisa stok: {$product->stock} {$product->unit}");
            }
        });
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Barang', 'quantity' => 'Jumlah',
            'recipient' => 'Penerima', 'purpose' => 'Keperluan',
            'transaction_date' => 'Tanggal Transaksi', 'notes' => 'Catatan',
        ];
    }
}
