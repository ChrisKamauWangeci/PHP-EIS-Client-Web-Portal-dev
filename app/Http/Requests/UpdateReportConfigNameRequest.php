<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportConfigNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_name' => ['required', 'string', 'min:2', 'max:255', 'unique:report_config_names,report_name,' . $this->report_config_name->id . ',id'],
        ];
    }
}
