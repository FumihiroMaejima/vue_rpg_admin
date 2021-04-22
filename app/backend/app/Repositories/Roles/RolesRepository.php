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
     * Get All Role Data.
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
     * Get Roles as List.
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

    /**
     * get Latest Role data.
     *
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public function getLatestRole(): object
    {
        return DB::table($this->model->getTable())
            ->latest()
            ->first();
    }

    /**
     * create Admin data.
     *
     * @return int
     */
    public function createRole(array $resource): int
    {
        return DB::table($this->model->getTable())->insert($resource);
    }

    /**
     * update Role data.
     *
     * @return int
     */
    public function updateRoleData(array $resource, int $id): int
    {
        // admins
        $admins = $this->model->getTable();

        // Query Builderのupdate
        return DB::table($admins)
            // ->whereIn('id', [$id])
            ->where('id', '=', [$id])
            ->where('deleted_at', '=', null)
            ->update($resource);
    }

    /**
     * delete Role data.
     * @param array $resource
     * @param int $id
     * @return int
     */
    public function deleteRoleData(array $resource, int $id): int
    {
        // admins
        $admins = $this->model->getTable();

        // Query Builderのupdate
        return DB::table($admins)
            // ->whereIn('id', [$id])
            ->where('id', '=', $id)
            ->where('deleted_at', '=', null)
            ->update($resource);
    }
}
