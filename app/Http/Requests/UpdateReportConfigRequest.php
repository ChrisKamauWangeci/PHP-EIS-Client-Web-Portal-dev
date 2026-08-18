<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company' => ['required', 'string', 'min:2', 'max:255'],
            'report_type' => ['required', 'string', 'min:2', 'max:255'],
            'report_name' => ['required', 'string', 'min:2', 'max:255', 'unique:report_configs,report_name,' . $this->report_config->id . ',id'],
            'report_schedule' => ['required', 'string', 'min:2', 'max:255'],
            'recipient_email' => ['required', 'email', 'min:2', 'max:255'],
            'destination_folder' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }
}
