<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlatformConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $platform_configuration = $this->route('platform_configuration');

        return [
            'company' => ['required', 'string', 'min:3', 'max:50'],
            'platform' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('platform_configurations')
                    ->where(fn ($query) => $query->where(
                        'company',
                        $this->input('company')
                    ))
                    ->ignore($platform_configuration->id),
                // Rule::unique('platform_configurations')->where(function ($query) {
                //     return $query->where('company', $this->input('company'));
                // }),
            ],
            'order_type' => ['required', 'string'],
            'submission_type' => ['required', 'string', 'in:auto,ondemand'],
            'wait_days' => ['required', 'integer', 'min:1', 'max:30'],
            'sequence' => ['required', 'integer', 'min:1', 'max:30'],
            // 'is_active' => ['required', 'boolean'],
        ];
    }
}
