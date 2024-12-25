<?php

namespace App\Models\Order;

use App\Models\Ticket\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLine extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'order_id',
        'ticket_id',
        'ticket_name',
        'ticket_price',
        'quantity',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
    ];

    /**
     * Get the order that the order line belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the ticket that the order line belongs to.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
