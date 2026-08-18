<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'H_Hospital2' => ['nullable', 'string', 'max:50'],
            'H_Affiliate' => ['nullable', 'string', 'max:50'],
            'H_ContactName' => ['nullable', 'string', 'max:50'],
            'H_Address' => ['nullable', 'string', 'max:50'],
            'H_City' => ['nullable', 'string', 'max:50'],
            'H_State' => ['nullable', 'string', 'max:2'],
            'H_Zip' => ['nullable', 'regex:/^\d{5}(?:-\d{4})?$/'],
            'H_Phone' => ['nullable', 'string', 'max:50'],
            'H_PhoneExt' => ['nullable', 'string', 'max:5'],
            'H_Fax' => ['nullable', 'string', 'max:14'],
            'H_AlternatePayment' => ['nullable', 'string'],
            'H_CopyService' => ['nullable', 'string'],
            'H_ROI' => ['nullable', 'string'],
            'H_LOR' => ['nullable', 'string'],
            'H_SpecialAuth' => ['nullable', 'string'],
            'H_ResponseTime' => ['nullable', 'string'],
            'H_TurnOverDays' => ['nullable', 'string'],
            'H_SendMethod' => ['nullable', 'string'],
            'H_ReceiveMethod' => ['nullable', 'string'],
            'H_SendMethodEmail' => ['nullable', 'email', 'string', 'max:50'],
            'H_ReceiveMethodEmail' => ['nullable', 'email', 'string', 'max:50'],
            'H_CheckPayTo' => ['nullable', 'string'],
            'H_PayAdvance' => ['nullable', 'string'],
            'H_NoEsignature' => ['nullable', 'string'],
            'H_PayMethod' => ['nullable', 'string'],
            'H_Fee' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'H_Note' => ['nullable', 'string'],
            'H_NoteDriver' => ['nullable', 'string'],
            'H_NoteUploader' => ['nullable', 'string'],
            'H_NoteBilling' => ['nullable', 'string'],
            'H_Note2' => ['nullable', 'string'],
            'H_MonFrom' => ['nullable', 'string'],
            'H_MonTo' => ['nullable', 'string'],
            'H_MonFrom2' => ['nullable', 'string'],
            'H_MonTo2' => ['nullable', 'string'],
            'H_TueFrom' => ['nullable', 'string'],
            'H_TueTo' => ['nullable', 'string'],
            'H_TueFrom2' => ['nullable', 'string'],
            'H_TueTo2' => ['nullable', 'string'],
            'H_WedFrom' => ['nullable', 'string'],
            'H_WedTo' => ['nullable', 'string'],
            'H_WedFrom2' => ['nullable', 'string'],
            'H_WedTo2' => ['nullable', 'string'],
            'H_ThuFrom' => ['nullable', 'string'],
            'H_ThuTo' => ['nullable', 'string'],
            'H_ThuFrom2' => ['nullable', 'string'],
            'H_ThuTo2' => ['nullable', 'string'],
            'H_FriFrom' => ['nullable', 'string'],
            'H_FriTo' => ['nullable', 'string'],
            'H_FriFrom2' => ['nullable', 'string'],
            'H_FriTo2' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'H_Hospital2.min' => 'Hospital 2 minimum 3 characters required',
            'H_Hospital2.max' => 'Hospital 2 maximum 50 characters required',
        ];
    }
}
