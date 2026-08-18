<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEhrorderssearchresultsexclusionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'managing_organization' => ['string', 'unique:ehrorderssearchresultsexclusions,managing_organization', 'min:3', 'max:250'],
        ];
    }
}
