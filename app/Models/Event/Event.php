<?php

namespace App\Models\Event;

use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $description
 * @property mixed $start_date
 * @property mixed $end_date
 * @property mixed $venue
 * @property mixed $address
 * @property mixed $status
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $organization_id
 * @property mixed $tickets
 */
class Event extends Model
{
    use HasFactory, HasUuids;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'organization_id',
        'slug',
        'name',
        'description',
        'start_date',
        'end_date',
        'total_capacity',
        'location',
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        static::saving(function ($event) {
            if (empty($event->slug)) {
                $event->slug = static::generateUniqueSlug($event->name);
            }
        });

        parent::boot();
    }

    /**
     * Generate a unique slug for the event.
     */
    protected static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Get the schedules for the event.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(EventSchedule::class);
    }

    /**
     * Get the organization that the event belongs to.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(EventTicket::class);
    }
}
