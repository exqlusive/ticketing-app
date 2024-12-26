<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed $date
 * @property mixed $start_time
 * @property mixed $end_time
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $event_id
 *
 * @method whenLoaded(string $string)
 */
class EventSchedule extends Model
{
    use HasFactory, HasUuids;

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
        'date' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    /**
     * Get the event that the schedule belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
