<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as RoleAlias;

class Role extends RoleAlias
{
    use HasUuids;
}
