<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDatachangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'created_by' => ['nullable', 'string', 'min:3', 'max:50'],
            'created_at' => ['nullable', 'date'],
        ];
    }
}
