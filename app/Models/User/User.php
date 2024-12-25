<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationUser;
use App\Models\Ticket\TicketReservation;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed $id
 * @property mixed $first_name
 * @property mixed last_name
 * @property mixed email
 * @property mixed is_organizer
 * @property mixed created_at
 * @property mixed updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\User\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_organizer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the organization that the user belongs to.
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')
            ->using(OrganizationUser::class)
            ->withPivot('id', 'role_id')
            ->withTimestamps();
    }

    /**
     * Get the tickets that the user has reserved.
     */
    public function ticketReservations(): HasMany
    {
        return $this->hasMany(TicketReservation::class);
    }

    /**
     * Check if the user is an organizer.
     */
    public function isOrganizer(): bool
    {
        return $this->is_organizer;
    }
}
