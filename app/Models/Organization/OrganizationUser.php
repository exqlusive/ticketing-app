<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationUser extends Pivot
{
    use HasUuids;

    /**
     * {@inheritdoc}
     */
    protected $table = 'organization_user';
}
