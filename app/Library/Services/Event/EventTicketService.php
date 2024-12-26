<?php

namespace App\Library\Services\Event;

use App\Models\Event\Event;
use App\Models\Event\EventTicket;
use Illuminate\Validation\ValidationException;

readonly class EventTicketService
{
    /**
     * Create a new event.
     *
     * @throws \Exception
     */
    public function create(Event $event, array $data): EventTicket
    {
        $existing = EventTicket::where('event_id', $event->id)
            ->where('type', $data['type'])
            ->exists();

        if ($existing) {
            throw ValidationException::withMessages([
                'ticket' => 'A ticket already exists for type '.strtolower($data['type']).'.',
            ]);
        }

        return $event->tickets()->create($data);
    }

    public function update(EventTicket $ticket, array $validated): EventTicket
    {
        $ticket->update($validated);

        return $ticket;
    }
}
