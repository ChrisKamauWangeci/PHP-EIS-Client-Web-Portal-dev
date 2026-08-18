<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'R_Address' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_City' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_State' => ['nullable', 'string', 'min:2', 'max:2'],
            'R_Zip' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_Phone' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_PhoneExt' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_Fax' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_ContactName' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_ContactEmail' => ['nullable', 'string', 'min:3', 'max:50'],
        ];
    }
}
