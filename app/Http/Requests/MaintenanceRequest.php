<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'product_id'   => ['required', 'exists:products,id'],
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'status'       => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'priority'     => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'cost'         => ['nullable', 'numeric', 'min:0'],
            'scheduled_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date', 'after_or_equal:scheduled_at'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Barang/Aset', 'title' => 'Judul', 'description' => 'Deskripsi',
            'status' => 'Status', 'priority' => 'Prioritas', 'cost' => 'Biaya',
            'scheduled_at' => 'Tanggal Dijadwalkan', 'completed_at' => 'Tanggal Selesai',
        ];
    }
}
