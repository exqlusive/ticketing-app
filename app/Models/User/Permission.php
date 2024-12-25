<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as PermissionAlias;

class Permission extends PermissionAlias
{
    use HasUuids;
}
