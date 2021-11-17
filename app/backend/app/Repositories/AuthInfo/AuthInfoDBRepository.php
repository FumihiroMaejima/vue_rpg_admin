<?php

namespace App\Repositories\AuthInfo;

use DB;

class AuthInfoDBRepository implements AuthInfoRepositoryTestInterface
{
    protected $table = 'admins';

    public function getAll()
    {
        return DB::table($this->table)->get();
    }
}
