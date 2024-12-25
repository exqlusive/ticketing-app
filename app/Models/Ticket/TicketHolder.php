<?php

namespace App\Models\Ticket;

use App\Models\Order\OrderLine;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketHolder extends Model
{
    use HasUuids;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'order_line_id',
        'name',
        'email',
        'status',
    ];

    /**
     * Get the order line that the ticket holder belongs to.
     */
    public function orderLine(): BelongsTo
    {
        return $this->belongsTo(OrderLine::class);
    }
}
