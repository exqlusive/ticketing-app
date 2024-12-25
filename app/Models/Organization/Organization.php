<?php

namespace App\Models\Organization;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($organization) {
            if (empty($organization->slug)) {
                $organization->slug = static::generateUniqueSlug($organization->name);
            }
        });
    }

    /**
     * Generate a unique slug for the organization.
     */
    protected static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name); // Base slug
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
}
