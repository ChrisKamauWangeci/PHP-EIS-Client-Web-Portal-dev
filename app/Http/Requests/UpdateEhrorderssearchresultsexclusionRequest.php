<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEhrorderssearchresultsexclusionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'managing_organization' => ['string', 'min:3', 'max:250', 'unique:ehrorderssearchresultsexclusions,managing_organization,' . $this->ehrorderssearchresultsexclusion->id . ',id'],
        ];
    }
}
