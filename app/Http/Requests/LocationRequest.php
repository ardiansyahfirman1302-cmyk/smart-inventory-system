<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $id = $this->route('location')?->id;

        return [
            'code'      => ['required', 'string', 'max:20', Rule::unique('locations', 'code')->ignore($id)],
            'name'      => ['required', 'string', 'max:150'],
            'address'   => ['nullable', 'string', 'max:500'],
            'pic_name'  => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function attributes(): array
    {
        return [
            'code' => 'Kode', 'name' => 'Nama Lokasi', 'address' => 'Alamat',
            'pic_name' => 'Penanggung Jawab', 'is_active' => 'Status Aktif',
        ];
    }
}
