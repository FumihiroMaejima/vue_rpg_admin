<?php

namespace App\Repositories\Admins;

use App\Models\Admins;
use App\Models\AdminsRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class AdminsRepository implements AdminsRepositoryInterface
{
    protected $model;
    protected $adminsRoleModel;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(Admins $model, AdminsRoles $adminsRoleModel)
    {
        $this->model = $model;
        $this->adminsRoleModel = $adminsRoleModel;
    }

    /**
     * Get All Admins Data.
     *
     * @return Collection
     */
    public function getAdmins(): Collection
    {
        return DB::table($this->model->getTable())->get();
        // Eloquent
        // return Admins::get();
    }

    /**
     * Get Admins as List.
     *
     * @return Collection
     */
    public function getAdminsList(): Collection
    {
        return DB::table($this->model->getTable())
            ->select('admins.id', 'admins.name', 'admins.email', 'admins_roles.role_id')
            ->leftJoin($this->adminsRoleModel->getTable(), 'admins.id', '=', 'admins_roles.admin_id')
            ->get();
    }
}
