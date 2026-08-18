<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'W_FirstName' => ['string', 'min:1', 'max:50'],
            'W_MiddleInit' => ['nullable', 'string', 'min:1', 'max:1'],
            'W_LastName' => ['string', 'min:2', 'max:50'],
            'W_SS' => ['nullable', 'numeric', 'digits:9'],
            'W_DOB' => ['nullable', 'date', 'after:1900-01-01', 'before:2030-12-31'],
            'W_Agent' => ['nullable', 'string', 'max:50'],
            'W_DrFollowup' => ['nullable', 'string'],
            'W_ShipFee1' => ['nullable', 'numeric', 'min:0'],
            'W_ShipFee2' => ['nullable', 'numeric', 'min:0'],
            'W_Tracking1' => ['nullable', 'string', 'max:30'],
            'W_Tracking2' => ['nullable', 'string', 'max:30'],
            'W_Requestor' => [
                'sometimes',
                'required',
                'string',
                Rule::exists('Requestor', 'R_Name')->where(function ($query) {
                    $query->where('R_Active', 1);
                }),
            ],
            'W_Contractor' => ['nullable', 'string'],
            'W_Owner' => ['nullable', 'string'],
            'W_DrFee1' => ['nullable', 'numeric', 'min:0', 'max:2000'],
            'W_DrFee2' => ['nullable', 'numeric', 'min:0', 'max:2000'],
            'W_DrFee' => ['nullable', 'numeric'],
            'W_DrCheckNo' => ['nullable', 'string', 'max:15'],
            'W_DrCheckNo2' => ['nullable', 'string', 'max:15'],
            'W_DrCheckDate' => ['nullable', 'date', 'after:2020-01-01', 'before:2030-12-31'],
            'W_DrCheckDate2' => ['nullable', 'date', 'after:2020-01-01', 'before:2030-12-31'],
            'W_DrInvoiceNo' => ['nullable', 'string', 'max:20'],
            'W_DrInvoiceNo2' => ['nullable', 'string', 'max:20'],
            'W_FollowUpStatus' => ['nullable', 'string', 'min:5', 'max:1000'],
            'W_FollowUpDt' => ['nullable', 'date', 'after:2020-01-01', 'before:2030-12-31'],
            'W_CompletedDate' => ['nullable', 'date', 'after:2020-01-01', 'before:2030-12-31'],
            'W_ExamStatus' => ['nullable', 'string'],
            'W_YearsOfRecord' => ['nullable', 'string'],
            'W_ContractorFee' => ['nullable', 'numeric', 'min:0'],
            'W_PolicyNo' => ['nullable', 'string'],
            'W_RecordNo' => ['nullable', 'string'],
            'W_TransNo' => ['nullable', 'numeric'],
            'W_NoFiles' => ['nullable', 'numeric', 'min:1', 'max:999'],
            'W_ImageFile' => ['nullable', 'string', 'max:50'],
            'W_ImagePages' => ['nullable', 'string'],
            'W_InsPolicy' => ['nullable', 'string'],
            'W_InsCompany' => ['nullable', 'string'],
            'W_Note2' => ['nullable', 'string'],
            'W_Urgent' => ['nullable', 'string'],
            'W_RequestorNote' => ['nullable', 'string'],
            'W_Gender' => ['nullable', 'string', 'in:M,F'],
        ];
    }

    public function messages()
    {
        return [
            'W_FirstName.min' => 'First Name minimum 2 characters required',
            'W_FirstName.max' => 'First Name maximum 20 characters required',
            'W_LastName.min' => 'Last Name minimum 2 characters required',
            'W_LastName.max' => 'Last Name maximum 20 characters required',
            'W_Requestor.exists' => 'The selected requestor is invalid or inactive.',
        ];
    }
}
