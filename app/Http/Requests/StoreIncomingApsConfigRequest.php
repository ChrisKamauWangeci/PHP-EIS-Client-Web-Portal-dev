<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomingApsConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source' => ['required', 'string', 'min:3', 'max:255'],
            'source_folder' => ['required', 'string', 'min:3', 'max:255'],
            'destination_folder' => ['required', 'string', 'min:3', 'max:255'],
            'back_up_folder' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
