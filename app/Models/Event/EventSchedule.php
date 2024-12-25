<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSchedule extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'event_id',
        'date',
        'start_time',
        'end_time',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time',
    ];

    /**
     * Get the event that the schedule belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
