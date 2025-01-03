<?php

namespace App\Models\Organization;

use App\Models\Event\Event;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @property mixed name
 * @property mixed slug
 * @property mixed email
 * @property mixed phone
 * @property mixed address
 * @property mixed city
 * @property mixed state
 * @property mixed postal_code
 * @property mixed country
 * @property mixed created_at
 * @property mixed updated_at
 */
class Organization extends Model
{
    use HasFactory, HasUuids;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        static::saving(function ($organization) {
            if (empty($organization->slug)) {
                $organization->slug = static::generateUniqueSlug($organization->name);
            }
        });

        parent::boot();
    }

    /**
     * Generate a unique slug for the organization.
     */
    protected static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check for uniqueness in the database
        while (self::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Get the owner of the organization.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user')
            ->using(OrganizationUser::class)
            ->withPivot('id', 'role_id')
            ->withTimestamps();
    }

    /**
     * Get the events that belong to the organization.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
