<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'R_LoginEmail' => ['required', 'string', 'min:3', 'max:50', 'unique:Requestor,R_LoginEmail,' . $this->requestor->R_ID . ',R_ID'],
            'R_Email' => ['nullable', 'email', 'min:3', 'max:50'],
            'R_SSOID' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_LoginEmail' => ['nullable', 'string', 'min:3', 'max:50'],
            'R_Active' => ['boolean'],
            'R_SuperUser' => ['boolean'],
            'R_ViewRecords' => ['boolean'],
            'R_NoOrder' => ['boolean'],
            'requestorrole_id' => ['nullable', 'integer'],
            'websiteconfig_id' => ['nullable', 'integer'],
        ];
    }
}
