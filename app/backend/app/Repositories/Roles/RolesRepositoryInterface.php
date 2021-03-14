<?php

namespace App\Repositories\Roles;

use Illuminate\Support\Collection;

interface RolesRepositoryInterface
{
    public function getRoles(): Collection;

    public function getRolesList(): Collection;
}
