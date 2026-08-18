<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocusignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_first_name' => ['string', 'min:2', 'max:50'],
            'patient_last_name' => ['string', 'min:2', 'max:50'],
            'patient_middle_name' => ['nullable', 'string'],
            // 'patient_email'  => ['sometimes', 'nullable', 'required_if:signingtype,email', 'email'],
            'patient_email' => ['required', 'email'],
            'signingtype' => ['required'],
            'dates_of_service_from' => ['nullable', 'string'],
            'dates_of_service_to' => ['nullable', 'string'],
            'dates_of_service_combined' => ['nullable', 'string'],
            'access_code' => ['nullable', 'string'],
            'environment' => ['nullable', 'string'],
            'emailsubject' => ['nullable', 'string', 'max:90'],
            'emailbody' => ['nullable', 'string'],
        ];
    }
}
