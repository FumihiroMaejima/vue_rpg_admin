<?php

namespace App\Services;

use App\Repositories\AuthInfo\AuthInfoRepositoryInterface;

class AuthInfoService
{
    protected $admin;

    public function __construct(AuthInfoRepositoryInterface $authInfoRepository)
    {
        $this->admin = $authInfoRepository;
    }

    public function getAdminInfo()
    {
        return $this->admin->getAdmin();
    }
}
