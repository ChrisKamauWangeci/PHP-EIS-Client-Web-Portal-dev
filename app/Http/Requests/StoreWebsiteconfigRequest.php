<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteconfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'show_facilities' => ['boolean'],
            'show_order' => ['boolean'],
            'show_files' => ['boolean'],
            'show_reports' => ['boolean'],
            'show_forms' => ['boolean'],
            'show_requestors' => ['boolean'],
            'show_contactmanager' => ['boolean'],
            'workorders_show_all_requestors' => ['boolean'],
            'workorder_inquiry' => ['boolean'],
            'workorder_upload_auth' => ['boolean'],
            'workorder_upload_aps' => ['boolean'],
            'workorder_additional_files' => ['boolean'],
            'is_admin' => ['boolean'],
        ];
    }
}
