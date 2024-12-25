<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'organization_id' => ['required', 'string', 'exists:organizations,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'venue' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];
    }
}
