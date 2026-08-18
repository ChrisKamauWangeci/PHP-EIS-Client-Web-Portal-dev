<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacilityformRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50', 'unique:eis.facilityforms,name,' . $this->facilityform->id . ',id'],
            'slug' => ['nullable', 'string', 'min:2', 'max:50', 'unique:eis.facilityforms,slug,' . $this->facilityform->id . ',id'],
            'file_name' => ['nullable', 'string', 'min:3', 'max:50', 'unique:eis.facilityforms,file_name,' . $this->facilityform->id . ',id'],
            'docusign_templateid_test' => ['nullable', 'string', 'min:3', 'max:50', 'unique:eis.facilityforms,docusign_templateid_test,' . $this->facilityform->id . ',id'],
            'docusign_templateid_production' => ['nullable', 'string', 'min:3', 'max:50', 'unique:eis.facilityforms,docusign_templateid_production,' . $this->facilityform->id . ',id'],
            'internal_form' => ['nullable', 'boolean'],
            'website' => ['nullable', 'string', 'min:2', 'max:100'],
            'version' => ['nullable', 'string', 'min:2', 'max:50'],
            'revision_date' => ['nullable', 'string', 'min:2', 'max:50'],
        ];
    }
}
