<?php

namespace App\Models\Event;

use App\Models\Ticket\TicketReservation;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $capacity
 * @property mixed $name
 * @property mixed $description
 * @property mixed $type
 * @property mixed $max_tickets_per_user
 * @property mixed $reservation_expiration_minutes
 * @property mixed $price
 * @property mixed $sold
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $event_id
 * @property mixed $id
 */
class EventTicket extends Model
{
    use HasUuids, HasFactory;

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
        'max_tickets_per_user' => 'integer',
        'reservation_expiration_minutes' => 'integer',
    ];

    protected $table = 'tickets';

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        static::creating(function (EventTicket $ticket): void {
            $ticket->type = strtolower($ticket->type);
        });

        static::updating(function (EventTicket $ticket): void {
            $ticket->type = strtolower($ticket->type);
        });

        parent::boot();
    }

    /**
     * Get the event that the ticket belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Check if tickets are available.
     */
    public function isAvailable(): bool
    {
        return $this->capacity > $this->sold;
    }

    /**
     * Get remaining tickets.
     */
    public function remaining(): int
    {
        return $this->capacity - $this->sold;
    }

    /**
     * Get the reservations for the ticket.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(TicketReservation::class);
    }
}
