<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workorder_id' => ['nullable', 'integer', 'min:100000', 'max:9999999'],
            'company' => ['nullable', 'string', 'exists:Company,C_Name', 'min:3', 'max:50'],
            'requestor_name' => ['required', 'string', 'min:3', 'max:50'],
            'requestor_email' => ['required', 'email', 'min:3', 'max:50'],
            'requestor_phone' => ['nullable', 'string', 'min:3', 'max:15'],
            'subject' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:3', 'max:4000'],
        ];
    }
}
