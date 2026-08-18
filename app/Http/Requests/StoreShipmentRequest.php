<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workorder_id' => ['integer', 'min:1', 'max:100000000', 'exists:Workorder,W_WorkOrder'],
            'fee' => ['nullable', 'numeric', 'min:1', 'max:1000'],
        ];
    }
}
