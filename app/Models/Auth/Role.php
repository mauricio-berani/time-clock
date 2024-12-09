<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Contracts\Role as RoleContract;
use App\Traits\Uuid;

class Role extends SpatieRole implements RoleContract
{

    use Uuid;
}
