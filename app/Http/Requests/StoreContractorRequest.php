<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'C_Name' => ['required', 'string', 'unique:Contractor', 'min:3', 'max:50'],
            'C_Email' => ['required', 'email', 'unique:Contractor', 'min:3', 'max:50'],
            'C_Password' => ['string', 'min:8', 'max:15'],
            'C_Location' => ['nullable', 'string', 'min:3', 'max:50'],
            'C_SysAdmin' => ['nullable'],
            'C_Caller' => ['nullable'],
            'C_Invoice' => ['nullable'],
            'accesslevel' => ['nullable'],
            'access_files' => ['nullable'],
            'is_active' => ['nullable'],
        ];
    }
}
