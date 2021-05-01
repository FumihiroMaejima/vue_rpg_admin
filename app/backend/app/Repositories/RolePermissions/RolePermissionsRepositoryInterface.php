<?php

namespace App\Repositories\RolePermissions;

use Illuminate\Support\Collection;

interface RolePermissionsRepositoryInterface
{
    public function getByRoleId(int $id): Collection;

    public function createRolePermission(array $resource): int;

    public function updateRolePermissionsData(array $resource, int $id): int;

    public function deleteRolePermissionsData(array $resource, int $id): int;

    public function deleteRolePermissionsByIds(array $resource, array $ids): int;
}
