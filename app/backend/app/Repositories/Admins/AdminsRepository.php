<?php

namespace App\Repositories\Admins;

use App\Models\Admins;
use App\Models\AdminsRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AdminsRepository implements AdminsRepositoryInterface
{
    protected $model;
    protected $adminsRolesModel;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(Admins $model, AdminsRoles $adminsRolesModel)
    {
        $this->model = $model;
        $this->adminsRolesModel = $adminsRolesModel;
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
        // admins
        $admins = $this->model->getTable();
        // admins_roles
        $adminsRoles = $this->adminsRolesModel->getTable();

        /* $selectColumn = [
            $admins.'.id', $admins.'.name', $admins.'.email', $adminsRoles.'.role_id as roleId'
        ]; */

        // collection
        return DB::table($admins)
            ->select([$admins . '.id', $admins . '.name', $admins . '.email', $adminsRoles . '.role_id as roleId'])
            ->leftJoin($adminsRoles, $admins.'.id', '=', $adminsRoles.'.admin_id')
            ->get();

        /*
        // sql
        $sql = DB::table($admins)
            ->select($selectColumn)
            ->leftJoin($adminsRoles, $admins . '.id', '=', $adminsRoles . '.admin_id')
            ->toSql();

        // Builder class
        $builder = DB::table($admins)
            ->select($selectColumn)
            ->leftJoin($adminsRoles, $admins . '.id', '=', $adminsRoles . '.admin_id');

        // get query log
        DB::enableQueryLog();
        $sql = DB::table($admins)
            ->select($selectColumn)
            ->leftJoin($adminsRoles, $admins . '.id', '=', $adminsRoles . '.admin_id')
            ->get();
        $log = DB::getQueryLog();
        */
    }

    /**
     * update Admin data.
     *
     * @return int
     */
    public function updateAdminData(Request $request, int $id): int
    {
        $keys = ['name', 'email'];
        $template = [
            $keys[0] => '\'' . $request->input($keys[0]) . '\'',
            $keys[1] => '\'' . $request->input($keys[1]) . '\''
        ];

        $bindings = ' SET ';
        foreach ($template as $key => $item) {
            $suffix = $key !== $keys[1] ? ', ' : '';
            $bindings = $bindings . $key . ' = ' . $item . $suffix;
        }

        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'bindings: ' . json_encode($bindings));
        // admins
        $admins = $this->model->getTable();
        $query = 'UPDATE ' . $admins . $bindings . ' where id = ?';

        return DB::update($query, [$id]);
    }
}
