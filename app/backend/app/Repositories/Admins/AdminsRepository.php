<?php

namespace App\Repositories\Admins;

use App\Models\Admins;
// use DB;
use Illuminate\Support\Facades\DB;
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

    /**
     * Get All Admins Data.
     *
     * @return Collection
     */
    public function getAdmins(): Collection
    {
        return DB::table($this->model->getTable())->get();
    }

    /**
     * Get Admins as List.
     *
     * @return Collection
     */
    public function getAdminsList(): Collection
    {
        return DB::table($this->model->getTable())
        ->select('id', 'name', 'email')
        ->get();
    }
}
