<?php

namespace App\Http\Resources\Event;

use App\Models\Event\EventTicket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventTicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var EventTicket $this */
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'price' => $this->price,
            'capacity' => $this->capacity,
            'sold' => $this->sold,
            'max_tickets_per_user' => $this->max_tickets_per_user,
            'reservation_expiration_minutes' => $this->reservation_expiration_minutes,
            'remaining' => $this->remaining(),
            'is_available' => $this->isAvailable(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
