<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
        ];
    }
}
