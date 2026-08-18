<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workorder_id' => ['sometimes', 'required', 'integer'],
            'db' => ['sometimes', 'required', 'string', 'in:eisuat,eis,usaa,nyl,ehr'],
            'status' => ['sometimes', 'required', 'string', 'min:3', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'min:3', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'min:3', 'max:4000'],
        ];
    }
}
