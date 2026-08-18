<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'min:3', 'max:50'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'value' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('settings')->where(function ($query) {
                    return $query
                        ->where('category', $this->input('category'))
                        ->where('name', $this->input('name'));
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'value.unique' => 'A setting with the same category, name, and value already exists.',
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
