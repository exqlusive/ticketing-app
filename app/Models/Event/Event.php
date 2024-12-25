<?php

namespace App\Models\Event;

use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, HasUuids;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
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
}
