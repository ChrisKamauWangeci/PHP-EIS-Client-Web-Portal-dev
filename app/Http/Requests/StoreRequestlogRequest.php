<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workorder_id' => ['integer'],
            'request_type' => ['string', 'min:1', 'max:50'],
            'notes' => ['string', 'min:5', 'max:1000'],
        ];
    }
}
