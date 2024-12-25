<?php

namespace App\Models\Ticket;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'type',
        'max_tickets_per_user',
        'reservation_expiration_minutes',
        'price',
        'capacity',
        'sold',
    ];

    protected $casts = [
        'price' => 'integer',
        'capacity' => 'integer',
        'sold' => 'integer',
    ];

    /**
     * Get the event that the ticket belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the reservations for the ticket.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(TicketReservation::class);
    }
}
