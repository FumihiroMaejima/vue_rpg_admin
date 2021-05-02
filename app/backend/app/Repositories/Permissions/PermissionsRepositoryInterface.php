<?php

namespace App\Repositories\Permissions;

use Illuminate\Support\Collection;

interface PermissionsRepositoryInterface
{
    public function getPermissions(): Collection;

    public function getPermissionsList(): Collection;

    public function createPermission(array $resource): int;

    public function updatePermissionData(array $resource, int $id): int;

    public function deletePermissionsData(array $resource, int $id): int;
}
