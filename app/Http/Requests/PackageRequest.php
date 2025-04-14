<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'vendor_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255', 'min:3', 'unique:packages,name,' . $id],
            'cod' => ['required', 'integer'],
            'is_active' => ['filled'],
            'is_suspension' => ['filled'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->can('developer');
    }
}
