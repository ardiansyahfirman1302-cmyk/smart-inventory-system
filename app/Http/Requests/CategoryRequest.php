<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id;

        return [
            'code'        => ['required', 'string', 'max:20', Rule::unique('categories', 'code')->ignore($id)],
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'code' => 'Kode',
            'name' => 'Nama Kategori',
            'description' => 'Deskripsi',
            'is_active' => 'Status Aktif',
        ];
    }
}
