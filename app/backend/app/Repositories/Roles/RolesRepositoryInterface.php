<?php

namespace App\Repositories\Roles;

use Illuminate\Support\Collection;

interface RolesRepositoryInterface
{
    public function getRoles(): Collection;

    public function getRolesList(): Collection;

    public function getLatestRole(): object;

    public function createRole(array $resource): int;

    public function updateRoleData(array $resource, int $id): int;

    public function deleteRoleData(array $resource, array $ids): int;
}
