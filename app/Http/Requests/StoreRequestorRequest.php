<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'R_Name' => ['required', 'string', 'unique:Requestor', 'min:3', 'max:50'],
            'R_Company' => ['required', 'string', 'exists:Company,C_Name', 'min:3', 'max:50'],
            'R_Email' => ['nullable', 'email', 'min:3', 'max:50'],
            'R_SSOID' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_LoginEmail' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_Password' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_Active' => ['boolean'],
            'R_SuperUser' => ['boolean'],
            'R_ViewRecords' => ['boolean'],
            'R_NoOrder' => ['boolean'],
        ];
    }
}
