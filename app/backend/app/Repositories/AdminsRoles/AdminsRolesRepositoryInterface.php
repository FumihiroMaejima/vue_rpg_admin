<?php

namespace App\Repositories\AdminsRoles;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface AdminsRolesRepositoryInterface
{
    public function updateAdminsRoleData(array $resource, int $id): int;
}
