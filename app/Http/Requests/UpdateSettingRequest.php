<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'min:3', 'max:50'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'value' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
