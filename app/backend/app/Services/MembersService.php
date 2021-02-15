<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Repositories\Admins\AdminsRepositoryInterface;

class MembersService
{
    protected $adminsRepository;

    public function __construct(AdminsRepositoryInterface $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
    }

    public function getAdmins()
    {
        return $this->adminsRepository->getAdmins();
    }
}
