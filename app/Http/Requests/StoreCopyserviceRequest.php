<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCopyserviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'C_CopyService' => ['nullable', 'string', 'unique:Copyservice', 'min:3', 'max:50'],
            'C_Address' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_City' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_State' => ['nullable', 'string', 'min:2', 'max:2'],
            'C_Zip' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_Phone' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_PhoneExt' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_Fax' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_ContactName' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_ContactEmail' => ['nullable', 'string', 'min:3', 'max:50'],
        ];
    }
}
