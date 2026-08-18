<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyupdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:companyupdates', 'min:3', 'max:50'],
            'filename' => ['required', 'string', 'unique:companyupdates', 'min:3', 'max:50'],
        ];
    }
}
