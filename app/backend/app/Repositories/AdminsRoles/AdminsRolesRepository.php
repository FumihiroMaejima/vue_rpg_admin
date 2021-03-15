<?php

namespace App\Repositories\AdminsRoles;

use App\Models\Admins;
use App\Models\AdminsRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AdminsRolesRepository implements AdminsRolesRepositoryInterface
{
    protected $model;
    protected $adminsModel;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(AdminsRoles $model, Admins $adminsModel)
    {
        $this->model = $model;
        $this->adminsModel = $adminsModel;
    }

    /**
     * update Admins Role.
     *
     * @return int
     */
    public function getByAdminId(int $adminId): Collection
    {
        // admins
        $adminsRoles = $this->model->getTable();

        // Query Builderのupdate
        return DB::table($adminsRoles)
            ->where('admin_id', '=', [$adminId])
            ->get();
    }

    /**
     * update Admins Role.
     *
     * @return int
     */
    public function updateAdminsRoleData(array $resource, int $adminId): int
    {
        // admins
        $adminsRoles = $this->model->getTable();

       /*  $table->foreignId('admin_id')->constrained('admins')->comment('管理者ID');
        $table->foreignId('role_id')->constrained('role')->comment('ロールID'); */

        // Query Builderのupdate
        return DB::table($adminsRoles)
            ->where('admin_id', '=', [$adminId])
            ->update($resource);
    }
}
