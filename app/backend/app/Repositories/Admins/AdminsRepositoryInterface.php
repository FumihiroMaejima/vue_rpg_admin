<?php

namespace App\Repositories\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface AdminsRepositoryInterface
{
    public function getAdmins(): Collection;

    public function getAdminsList(): Collection;

    public function createAdmin(array $resource): int;

    public function updateAdminData(array $resource, int $id): int;
}
