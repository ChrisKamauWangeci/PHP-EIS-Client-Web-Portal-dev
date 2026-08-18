<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOver60daysnoticeconfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Company' => ['required', 'string', 'min:3', 'max:50'],
            'EmailTo' => ['required', 'email', 'min:3', 'max:50'],
            'SendNoticeDays' => ['required', 'integer', 'min:1', 'max:999'],
            'CancelDays' => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }
}
