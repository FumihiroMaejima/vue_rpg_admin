<?php

namespace App\Repositories\AuthInfo;

use App\Models\Admins;

class AuthInfoEQRepository implements AuthInfoRepositoryTestInterface
{
    protected $table = 'admins';

    public function getAll()
    {
        return Admins::all();
    }
}
