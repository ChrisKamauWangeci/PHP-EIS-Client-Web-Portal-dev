<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'C_Name' => ['required', 'string', 'unique:Company', 'min:3', 'max:50'],
            'C_WebID' => ['required', 'string', 'unique:Company', 'min:3', 'max:50'],
            'C_Contact' => ['required', 'string', 'min:3', 'max:50'],
            'C_ContactMail' => ['email', 'min:3', 'max:50'],
            'C_Address' => ['nullable', 'string', 'min:3', 'max:100'],
            'C_City' => ['nullable', 'string', 'min:2', 'max:50'],
            'C_State' => ['nullable', 'string', 'min:2', 'max:50'],
            'C_Zip' => ['nullable', 'string', 'min:2', 'max:20'],
            'C_Phone' => ['nullable', 'string', 'min:7', 'max:20'],
            'C_Fax' => ['nullable', 'string', 'min:7', 'max:20'],
            'C_Note' => ['nullable', 'string', 'max:2000'],
            'C_ContactNote' => ['nullable', 'string', 'max:2000'],
            'C_Instruction' => ['nullable', 'string', 'max:2000'],
            'years_of_records' => ['nullable', 'string'],
            'C_APSOnly' => ['nullable', 'boolean'],
            'C_EHR' => ['nullable', 'boolean'],
            'C_MFA' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'C_Name.required' => 'Company Name is required',
            'C_Name.unique' => 'Company Name must be unique',
            'C_Contact.required' => 'Contact Name is required',
            'C_Contact.unique' => 'Contact Name must be unique',
            'C_WebID.required' => 'Web ID is required',
            'C_WebID.unique' => 'Web ID must be unique',
            'C_ContactMail.email' => 'Contact Email must be a valid email address',
            'C_Address.required' => 'Address is required',
            'C_City.required' => 'City is required',
            'C_State.required' => 'State is required',
            'C_Zip.required' => 'Zip is required',
            'C_Phone.required' => 'Phone is required',
            'C_Fax.required' => 'Fax is required',
        ];
    }
}
