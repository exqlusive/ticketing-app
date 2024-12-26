<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventTicketStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'max_tickets_per_user' => ['required', 'integer', 'min:1'],
            'reservation_expiration_minutes' => ['required', 'integer', 'min:1'],
        ];
    }
}
