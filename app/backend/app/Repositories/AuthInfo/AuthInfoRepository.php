<?php

namespace App\Repositories\AuthInfo;

use DB;

class AuthInfoRepository implements AuthInfoRepositoryInterface
{
    protected $table = 'admins';

    public function getAdmin()
    {
        return DB::table($this->table)->get();
    }
}
