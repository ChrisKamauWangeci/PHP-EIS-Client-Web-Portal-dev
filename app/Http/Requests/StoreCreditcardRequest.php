<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditcardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CC_No' => ['required', 'string', 'unique:CreditCardInfo', 'min:15', 'max:19'],
            'CC_Name' => ['required', 'string', 'min:3', 'max:50'],
            'ExpDate' => ['required', 'string', 'min:5', 'max:5'],
            'CVC_No' => ['required', 'string', 'min:3', 'max:4'],
        ];
    }
}
