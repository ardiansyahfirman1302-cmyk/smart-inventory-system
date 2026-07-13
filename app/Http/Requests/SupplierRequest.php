<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $id = $this->route('supplier')?->id;

        return [
            'code'           => ['required', 'string', 'max:20', Rule::unique('suppliers', 'code')->ignore($id)],
            'name'           => ['required', 'string', 'max:150'],
            'contact_person' => ['nullable', 'string', 'max:100'],
            'phone'          => ['nullable', 'string', 'max:25'],
            'email'          => ['nullable', 'email', 'max:150'],
            'address'        => ['nullable', 'string', 'max:1000'],
            'is_active'      => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function attributes(): array
    {
        return [
            'code' => 'Kode', 'name' => 'Nama Supplier', 'contact_person' => 'Kontak Person',
            'phone' => 'Telepon', 'email' => 'Email', 'address' => 'Alamat', 'is_active' => 'Status Aktif',
        ];
    }
}
