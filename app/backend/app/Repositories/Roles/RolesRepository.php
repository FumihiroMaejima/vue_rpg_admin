<?php

namespace App\Repositories\Roles;

use App\Models\Role;
use App\Models\AdminsRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RolesRepository implements RolesRepositoryInterface
{
    protected $model;
    protected $adminsRolesModel;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(Role $model, AdminsRoles $adminsRolesModel)
    {
        $this->model = $model;
        $this->adminsRolesModel = $adminsRolesModel;
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
        // admins_roles
        // $adminsRoles = $this->adminsRolesModel->getTable();

        /* $selectColumn = [
            $roles . '.name as text', $roles. '.id as roleId'
        ]; */

        // collection
        return DB::table($roles)
            ->select([$roles . '.name as text', $roles . '.id as value'])
            // ->leftJoin($adminsRoles, $roles.'.id', '=', $adminsRoles.'.admin_id')
            ->get();
    }
}
