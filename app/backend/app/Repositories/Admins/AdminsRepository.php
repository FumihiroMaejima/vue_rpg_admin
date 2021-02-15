<?php

namespace App\Repositories\Admins;

use App\Models\Admins;
use DB;
use Illuminate\Support\Collection;

class AdminsRepository implements AdminsRepositoryInterface
{
    protected $model;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(Admins $model)
    {
        $this->model = $model;
    }

    public function getAdmins()
    {
        return DB::table($this->model->getTable())->get();
    }
}
