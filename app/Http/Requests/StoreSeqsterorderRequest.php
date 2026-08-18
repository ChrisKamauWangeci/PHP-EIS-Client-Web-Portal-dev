<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeqsterorderRequest extends FormRequest
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
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'min:3', 'max:50'],
            'birthday' => ['nullable', 'date'],
            'address_1' => ['nullable', 'string'],
            'address_2' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];
    }
}
