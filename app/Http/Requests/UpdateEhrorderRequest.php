<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEhrorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_provider' => ['sometimes', 'string', 'min:2', 'max:255'],
            'workorder_id' => ['sometimes', 'integer'],
            'company_name' => ['sometimes', 'string', 'min:2', 'max:255'],
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'middle_name' => ['nullable', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'social_security_number' => ['nullable', 'string', 'min:9', 'max:9'],
            'gender' => ['nullable', 'string', 'max:1', 'in:M,F,O'],
            'birth_date' => ['nullable', 'date'],
            'email_address' => ['nullable', 'email', 'max:255'],
            'home_phone' => ['nullable', 'string', 'max:255'],
            'cell_phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:255'],
            'date_of_service_from' => ['nullable', 'date'],
            'auth_file_path' => ['nullable', 'string', 'max:255'],
            'submission_type' => ['nullable', 'string', 'in:auto,nonauto'],
            'status' => ['nullable', 'string', 'max:255'],
            'submitted_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'submission_type.in' => 'Submission type must be either "auto" or "nonauto".',
            'status.max' => 'Status cannot exceed 255 characters.',
            'submitted_at.date_format' => 'Submitted at must be in the format Y-m-d H:i:s.',
        ];
    }
}
