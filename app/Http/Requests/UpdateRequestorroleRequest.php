<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestorroleRequest extends FormRequest
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
                'min:1',
                'max:50',
                'exists:Company,C_Name',
            ],
            'name' => [
                'required',
                'string',
                'min:1',
                'max:50',
                Rule::unique('requestorroles', 'name')
                    ->ignore($this->requestorrole->id)
                    ->where('company', $this->input('company')),
            ],
            'role' => [
                'required',
                'string',
                'min:1',
                'max:50',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('requestorroles', 'role')
                    ->ignore($this->requestorrole->id)
                    ->where('company', $this->input('company')),
            ],
            'active_in_order' => [
                'required',
                'boolean',
            ],
            'active_in_search' => [
                'required',
                'boolean',
            ],
        ];
    }
}
