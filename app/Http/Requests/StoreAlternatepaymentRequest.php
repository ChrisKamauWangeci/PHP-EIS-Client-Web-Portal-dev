<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlternatepaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'A_CopyService' => ['nullable', 'string', 'unique:AlternatePayment', 'min:3', 'max:50'],
            'A_Address' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_City' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_State' => ['nullable', 'string', 'min:2', 'max:2'],
            'A_Zip' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_Phone' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_PhoneExt' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_Fax' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_ContactName	' => ['nullable', 'string', 'min:3', 'max:50'],
            'A_ContactEmail' => ['nullable', 'string', 'min:3', 'max:50'],
        ];
    }
}
