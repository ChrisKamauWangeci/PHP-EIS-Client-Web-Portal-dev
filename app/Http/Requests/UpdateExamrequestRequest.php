<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamrequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'E_Address' => ['nullable', 'string', 'min:1', 'max:50'],
            'E_City' => ['nullable', 'string', 'min:1', 'max:50'],
            'E_State' => ['nullable', 'string', 'min:1', 'max:2'],
            'E_Zip' => ['nullable', 'string', 'min:1', 'max:10'],
            'E_HomePhone' => ['nullable', 'string', 'min:1', 'max:14'],
            'E_CellPhone' => ['nullable', 'string', 'min:1', 'max:14'],
            'E_ApplicantEmail' => ['nullable', 'email', 'min:1', 'max:80'],
        ];
    }
}
