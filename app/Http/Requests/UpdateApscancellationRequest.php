<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApscancellationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'IsNotified' => ['nullable', 'boolean'],
            'CancellationStatusID' => ['integer'],
        ];
    }
}
