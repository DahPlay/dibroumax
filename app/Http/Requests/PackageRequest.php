<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function rules (): array
    {
        return [
            'vendor_id' => ['nullable','integer'],
            'name' => ['required', 'string', 'max:255', 'min:3', 'unique:packages,name'],
            'cod' => ['required', 'integer'],
            'is_active' => ['filled'],

        ];
    }

    public function authorize (): bool
    {
        return auth()->user()->can('developer');
    }
}
