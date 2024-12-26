<?php

namespace App\Http\Requests\Event;

use App\Models\Event\EventTicket;
use Illuminate\Foundation\Http\FormRequest;

class EventTicketUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'type' => ['sometimes', 'string'],
            'price' => ['sometimes', 'integer', 'min:0'],
            'capacity' => ['sometimes', 'integer', 'min:1'],
            'max_tickets_per_user' => ['sometimes', 'integer', 'min:1'],
            'reservation_expiration_minutes' => ['sometimes', 'integer', 'min:1'],
        ];
    }
    /**
     * Additional validation logic for duplicate checks
     */
    public function withValidator($validator)
    {
        $event = $this->route('event') ? $this->route('event') : null;

        if (! $event) {
            $validator->errors()->add('event_id', 'The specified event does not exist.');

            return;
        }

        $ticket = $this->route('ticket');

        if (! $ticket) {
            $validator->errors()->add('ticket', 'The specified ticket does not exist.');

            return;
        }

        $validator->after(function ($validator) use ($event, $ticket) {
            $type = $this->input('type');

            if (
                $type &&
                $ticket->type !== $type &&
                EventTicket::where('event_id', $event->id)
                    ->where('type', $type)
                    ->exists()
            ) {
                $validator->errors()->add(
                    'ticket',
                    'A ticket already exists for type ' . strtolower($type) . '.'
                );
            }
        });
    }
}
