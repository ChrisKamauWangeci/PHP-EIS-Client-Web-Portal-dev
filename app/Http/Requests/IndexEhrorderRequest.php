<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexEhrorderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => ['nullable', 'integer'],
            'workorder_id' => ['nullable', 'integer'],
            'service_provider' => ['nullable', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9_\s]+$/'],
            'company_name' => ['nullable', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'first_name' => ['nullable', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['nullable', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'gender' => ['nullable', 'string', 'in:M,F'],
            'status' => ['nullable', 'string', 'min:2', 'max:50', 'alpha_num'],
            'dbfield' => ['nullable', 'string'],
            'dbconditions' => ['nullable', 'string'],
            'dbvalue' => ['nullable', 'string'],
            'submitted_at_from' => ['nullable', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:today'],
            'submitted_at_to' => ['nullable', 'date', 'after_or_equal:submitted_at_from', 'before_or_equal:today'],
            'created_at_from' => ['nullable', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:today'],
            'created_at_to' => ['nullable', 'date', 'after_or_equal:created_at_from', 'before_or_equal:today'],
        ];
    }
}
