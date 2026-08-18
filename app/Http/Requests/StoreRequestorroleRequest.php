<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequestorroleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company' => [
                'required',
                'string',
                'max:50',
                'exists:Company,C_Name',
            ],
            'name' => [
                'required',
                'string',
                'min:1',
                'max:50',
                Rule::unique('requestorroles', 'name')
                    ->where('company', $this->input('company')),
            ],
            'role' => [
                'required',
                'string',
                'min:1',
                'max:50',
                'regex:/^[a-z0-9-_]+$/',
                Rule::unique('requestorroles', 'role')
                    ->where('company', $this->input('company')),
            ],
        ];
    }
}
