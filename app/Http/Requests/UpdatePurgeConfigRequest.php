<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurgeConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'min:3', 'max:255'],
            'folder_name' => ['required', 'string', 'min:3', 'max:255', 'unique:purge_configs,folder_name,' . $this->purge_config->id . ',id'],
            'source_path' => ['required', 'string', 'min:3', 'max:255'],
            'destination_path' => ['required', 'string', 'min:3', 'max:255'],
            'frequency' => ['required', 'string', 'min:1', 'max:255'],
            'purge_after_days' => ['required', 'integer', 'min:1', 'max:730'],
        ];
    }
}
