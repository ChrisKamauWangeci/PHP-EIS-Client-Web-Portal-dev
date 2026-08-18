<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePlatformConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'company' => ['required', 'string', 'min:3', 'max:50'],
            'platform' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('platform_configurations')->where(function ($query) {
                    return $query->where('company', $this->input('company'));
                }),
            ],
            'order_type' => ['required', 'string'],
            'submission_type' => ['required', 'string', 'in:auto,ondemand'],
            'wait_days' => ['required', 'integer', 'min:1', 'max:30'],
            'sequence' => ['required', 'integer', 'min:1', 'max:30'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function failedValidation(Validator $validator)
    {

        if ($this->hasHeader('HX-Request')) {
            $html = view('components.form.errors', ['errors' => $validator->errors()])->render();
            throw new HttpResponseException(response($html, 200));
        }

        parent::failedValidation($validator);
    }
}
