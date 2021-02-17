<?php

namespace App\Repositories\Admins;

use Illuminate\Support\Collection;

interface AdminsRepositoryInterface
{
    public function getAdmins(): Collection;

    public function getAdminsList(): Collection;
}
