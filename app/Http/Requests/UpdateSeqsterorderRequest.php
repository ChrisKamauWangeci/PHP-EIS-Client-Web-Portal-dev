<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeqsterorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_title' => ['nullable', 'string'],
            'site_name' => ['nullable', 'string'],
            'company' => ['nullable', 'string'],
            'workorder_id' => ['nullable', 'string'],
            'patient_id' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'min:3', 'max:50'],
            'postal_code' => ['nullable', 'string'],
            'birthday' => ['nullable', 'date'],
            'status' => ['nullable', 'string'],
            'api_error' => ['nullable', 'string'],
            'emailed_at' => ['nullable', 'date'],
        ];
    }
}
