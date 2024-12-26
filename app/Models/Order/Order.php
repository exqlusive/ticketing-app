<?php

namespace App\Models\Order;

use App\Models\Event\Event;
use App\Models\Event\EventTicket;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasUuids;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'user_name',
        'user_email',
        'event_name',
        'total_amount',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'total_amount' => 'integer',
    ];

    /**
     * Get the user that the order belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that the order belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the tickets for the order.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(EventTicket::class);
    }

    /**
     * Get the order lines for the order.
     */
    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }
}
