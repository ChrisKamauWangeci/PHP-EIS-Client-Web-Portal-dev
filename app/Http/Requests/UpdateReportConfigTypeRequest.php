<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportConfigTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_type' => ['required', 'string', 'min:2', 'max:255', 'unique:report_config_types,report_type,' . $this->report_config_type->id . ',id'],
        ];
    }
}
