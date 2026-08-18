<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCopyserviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'C_Address' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_City' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_State' => ['nullable', 'string', 'min:2', 'max:2'],
            'C_Zip' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_Phone' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_PhoneExt' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_Fax' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_ContactName' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_ContactEmail' => ['nullable', 'string', 'min:3', 'max:50'],
            'attestation_required' => ['boolean'],
            'attestation_file' => ['nullable', 'string', 'min:3', 'max:100', 'unique:\App\Models\Copyservice,attestation_file,' . $this->copyservice->C_ID . ',C_ID'],
            'attestation_expiration' => ['nullable', 'date'],
        ];
    }
}
