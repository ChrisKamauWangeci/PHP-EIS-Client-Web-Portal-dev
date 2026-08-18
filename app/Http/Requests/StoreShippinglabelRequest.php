<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippinglabelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'W_WorkOrder' => ['required', 'integer', 'max:10000000', 'exists:WorkOrder,W_WorkOrder'],
            'label' => ['required', 'in:1,2'],
            'W_Tracking' => ['required', 'string', 'min:1', 'max:50'],
            'shipping_label' => ['required', 'file', 'mimes:pdf', 'max:20000'],
        ];
    }
}
