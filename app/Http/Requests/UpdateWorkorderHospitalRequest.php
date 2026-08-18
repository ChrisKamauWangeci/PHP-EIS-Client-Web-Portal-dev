<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkorderHospitalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'W_WorkOrder' => ['required', 'integer'],
            'H_ID' => ['required', 'integer'],
            'hospital_name' => ['required', 'string', 'min:3', 'max:100', 'unique:Hospital,H_Hospital,' . $this->H_ID . ',H_ID'],
        ];
    }
}
