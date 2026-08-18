<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkorderpaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_type' => ['required', 'string', 'min:3', 'max:50'],
            'amount' => ['required', 'numeric', 'min:0', 'max:500'],
            'status' => ['required'],
        ];
    }
}
