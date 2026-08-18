<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyupdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:companyupdates,name,' . $this->companyupdate->id . ',id'],
            'filename' => ['required', 'string', 'min:3', 'max:50', 'unique:companyupdates,filename,' . $this->companyupdate->id . ',id'],
        ];
    }
}
