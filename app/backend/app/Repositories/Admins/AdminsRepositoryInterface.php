<?php

namespace App\Repositories\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface AdminsRepositoryInterface
{
    public function getAdmins(): Collection;

    public function getAdminsList(): Collection;

    public function updateAdminData(Request $request, int $id): int;
}
