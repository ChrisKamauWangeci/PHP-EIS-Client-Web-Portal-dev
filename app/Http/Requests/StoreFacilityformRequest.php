<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacilityformRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:eis.facilityforms', 'min:2', 'max:50'],
            'slug' => ['nullable', 'string', 'unique:eis.facilityforms', 'min:2', 'max:50'],
            'file_name' => ['nullable', 'string', 'unique:eis.facilityforms', 'min:2', 'max:50'],
            'docusign_templateid_production' => ['nullable', 'string', 'unique:eis.facilityforms', 'min:2', 'max:50'],
            'internal_form' => ['nullable', 'boolean'],
            'website' => ['nullable', 'string', 'min:2', 'max:100'],
            'version' => ['nullable', 'string', 'min:2', 'max:50'],
            'revision_date' => ['nullable', 'string', 'min:2', 'max:50'],
        ];
    }
}
