<?php

namespace App\Models\Organization;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
    ];

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
