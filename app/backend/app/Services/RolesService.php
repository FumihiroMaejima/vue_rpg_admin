<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Roles\RolesRepositoryInterface;
use App\Http\Resources\RolesCollection;
use App\Services\Notifications\MemberSlackNotificationService;
use App\Repositories\AdminsRoles\AdminsRolesRepositoryInterface;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Http\Resources\AdminUpdateResource;
use App\Http\Resources\AdminUpdateNotificationResource;
use App\Http\Resources\AdminsRolesUpdateResource;
use App\Http\Resources\AdminsRolesDeleteResource;
use App\Http\Resources\AdminsRolesCreateResource;
use App\Http\Resources\AdminsResource;
use App\Http\Resources\AdminsCSVCollection;
use App\Http\Resources\AdminsCollection;
use App\Http\Resources\AdminDeleteResource;
use App\Http\Resources\AdminCreateResource;
use App\Http\Resources\RoleDeleteResource;
use App\Http\Resources\RoleCreateResource;
use App\Http\Resources\RoleUpdateResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RolesServiceResource;
use App\Http\Resources\RolesListResource;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Requests\RoleDeleteRequest;
use App\Exports\AdminsExport;
use Exception;

class RolesService
{
    protected $rolesRepository;

    /**
     * create PermissionsService instance
     * @param  \App\RolesService\Roles\RolesRepositoryInterface  $rolesRepository
     * @return void
     */
    public function __construct(RolesRepositoryInterface $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    /**
     * get roles data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRoles(Request $request)
    {
        $data = $this->rolesRepository->getRoles();
        $resourceCollection = app()->make(RolesServiceResource::class, ['resource' => $data]);

        return response()->json($resourceCollection->toArray($request), 200);
    }

    /**
     * get roles data for frontend parts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRolesList(Request $request)
    {
        $data = $this->rolesRepository->getRolesList();
        // サービスコンテナからリソースクラスインスタンスを依存解決
        // コンストラクタのresourceに割り当てる値を渡す
        $resource = app()->make(RolesListResource::class, ['resource' => $data]);
        // $resource = app()->make(AdminsResource::class, ['resource' => $data]);

        return response()->json($resource->toArray($request), 200);
    }

    /**
     * download role data service
     *
     * @param  \Illuminate\Http\Request;  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadCSV(Request $request)
    {
        $data = $this->rolesRepository->getRolesList();

        return Excel::download(new AdminsExport($data), 'roles_info_' . Carbon::now()->format('YmdHis') . '.csv');
    }

    /**
     * update role data service
     *
     * @param  \App\Http\Requests\RoleCreateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createRole(RoleCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $resource = app()->make(RoleCreateRequest::class, ['resource' => $request])->toArray($request);

            $insertCount = $this->rolesRepository->createRole($resource); // if created => count is 1
            $latestAdmin = $this->rolesRepository->getLatestRole();

            // 権限情報の作成
            $adminsRolesResource = app()->make(AdminsRolesCreateResource::class, ['resource' => $latestAdmin])->toArray($request);
            $insertAdminsRolesCount = $this->adminsRolesRepository->createAdminsRole($adminsRolesResource);

            DB::commit();

            // 作成されている場合は304
            $message = ($insertCount > 0 && $insertAdminsRolesCount > 0) ? 'success' : 'Bad Request';
            $status = ($insertCount > 0 && $insertAdminsRolesCount > 0) ? 201 : 401;

            return response()->json(['message' => $message, 'status' => $status], $status);
        } catch (Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }

    /**
     * update role data service
     *
     * @param  \App\Http\Requests\RoleUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoleData(RoleUpdateRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $resource = app()->make(RoleUpdateRequest::class, ['resource' => $request])->toArray($request);

            $updatedRowCount = $this->rolesRepository->updateRoleData($resource, $id);

            // 権限情報の更新
            $roleIdResource = app()->make(AdminsRolesUpdateResource::class, ['resource' => $request])->toArray($request);
            $updatedAdminsRolesRowCount = $this->adminsRolesRepository->updateRoleData($roleIdResource, $id);

            // slack通知
            $attachmentResource = app()->make(AdminUpdateNotificationResource::class, ['resource' => ":tada: Update Member Data \n"])->toArray($request);
            app()->make(MemberSlackNotificationService::class)->send('update member data.', $attachmentResource);

            DB::commit();

            // 更新されていない場合は304
            $message = ($updatedRowCount > 0 || $updatedAdminsRolesRowCount > 0) ? 'success' : 'not modified';
            $status = ($updatedRowCount > 0 || $updatedAdminsRolesRowCount > 0) ? 200 : 304;

            return response()->json(['message' => $message, 'status' => $status], $status);
        } catch (Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }

    /**
     * delete role data service
     *
     * @param  \App\Http\Requests\RoleDeleteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRole(RoleDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;

            $resource = app()->make(RoleDeleteRequest::class, ['resource' => $request])->toArray($request);

            $deleteRowCount = $this->rolesRepository->deleteRoleData($resource, $request->id);

            // 権限情報の更新
            $roleIdResource = app()->make(AdminsRolesDeleteResource::class, ['resource' => $request])->toArray($request);
            $deleteAdminsRolesRowCount = $this->adminsRolesRepository->deleteAdminsRoleData($roleIdResource, $id);

            DB::commit();

            // 更新されていない場合は304
            $message = ($deleteRowCount > 0 && $deleteAdminsRolesRowCount > 0) ? 'success' : 'not deleted';
            $status = ($deleteRowCount > 0 && $deleteAdminsRolesRowCount > 0) ? 200 : 401;

            return response()->json(['message' => $message, 'status' => $status], $status);
        } catch (Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }
}
