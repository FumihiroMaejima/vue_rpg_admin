<?php

namespace App\Repositories\Roles;

use App\Models\Roles;
use App\Models\AdminsRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RolesRepository implements RolesRepositoryInterface
{
    protected $model;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(Roles $model)
    {
        $this->model = $model;
    }

    /**
     * Get All Admins Data.
     *
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return DB::table($this->model->getTable())->get();
        // Eloquent
        // return Role::get();
    }

    /**
     * Get Admins as List.
     *
     * @return Collection
     */
    public function getRolesList(): Collection
    {
        // admins
        $roles = $this->model->getTable();

        // collection
        return DB::table($roles)
            ->select([$roles . '.id', $roles . '.name'])
            ->get();
    }
}
