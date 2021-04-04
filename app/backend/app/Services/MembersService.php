<?php

namespace App\Services;

use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Http\Requests\MemberDeleteRequest;
use App\Http\Resources\AdminsCollection;
use App\Http\Resources\AdminsResource;
use App\Http\Resources\AdminsRolesCreateResource;
use App\Http\Resources\AdminsRolesUpdateResource;
use App\Http\Resources\AdminsRolesDeleteResource;
use App\Http\Resources\AdminUpdateResource;
use App\Http\Resources\AdminDeleteResource;
use App\Http\Resources\AdminCreateResource;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Repositories\AdminsRoles\AdminsRolesRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\AdminsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;

class MembersService
{
    protected $adminsRepository;
    protected $adminsRolesRepository;

    public function __construct(AdminsRepositoryInterface $adminsRepository, AdminsRolesRepositoryInterface $adminsRolesRepository)
    {
        $this->adminsRepository = $adminsRepository;
        $this->adminsRolesRepository = $adminsRolesRepository;
    }

    public function getAdmins(Request $request)
    {
        $data = $this->adminsRepository->getAdminsList();
        // サービスコンテナからリソースクラスインスタンスを依存解決
        // コンストラクタのresourceに割り当てる値を渡す
        $resourceCollection = app()->make(AdminsCollection::class, ['resource' => $data]);
        // $resource = app()->make(AdminsResource::class, ['resource' => $data]);

        return response()->json($resourceCollection->toArray($request), 200);
        // return response()->json($resource->toArray($request), 200);
    }

    /**
     * update member data service
     *
     * @param  \Illuminate\Http\Request;  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function downloadCSV(Request $request)
    {
        $data = $this->adminsRepository->getAdminsList();
        // サービスコンテナからリソースクラスインスタンスを依存解決
        // コンストラクタのresourceに割り当てる値を渡す
        $resourceCollection = app()->make(AdminsCollection::class, ['resource' => $data]);
        // $resource = app()->make(AdminsResource::class, ['resource' => $data]);

        // return Excel::store(new AdminsExport($data), 'file/' . 'output.xlsx', 'local');
        // return Excel::store(new AdminsExport($data), Config::get('myapp.file.download.storage.local') . 'output.xlsx', Config::get('app.env', 'local'));
        if (Config::get('app.env') === 'production') {
            return Excel::download(new AdminsExport($data), 'output.xlsx');
        } else {
            return Excel::download(new AdminsExport($data), 'output.csv');
            // return Excel::store(new AdminsExport($data), Config::get('myapp.file.download.storage.local') . 'output.xlsx', 'local');
        }

        // return Excel::store(new AdminsExport, 'file/'. 'output.xlsx', 'local');
        // return Excel::download(new AdminsExport, 'output.xlsx');
        // return response()->json($resourceCollection->toArray($request), 200);
    }

    /**
     * update member data service
     *
     * @param  \App\Http\Requests\MemberCreateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createMember(MemberCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'request all: ' . json_encode($request->all()));

            $resource = app()->make(AdminCreateResource::class, ['resource' => $request])->toArray($request);

            $insertCount = $this->adminsRepository->createAdmin($resource); // if created => count is 1
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'insertCount: ' . json_encode($insertCount));
            $latestAdmin = $this->adminsRepository->getLatestAdmin();

            // 権限情報の作成
            $adminsRolesResource = app()->make(AdminsRolesCreateResource::class, ['resource' => $latestAdmin])->toArray($request);
            $insertAdminsRolesCount = $this->adminsRolesRepository->createAdminsRole($adminsRolesResource);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'roleIdResource: ' . json_encode($adminsRolesResource));
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'insert roles conut: ' . json_encode($insertAdminsRolesCount));

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
     * update member data service
     *
     * @param  \App\Http\Requests\MemberUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMemberData(MemberUpdateRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'request all: ' . json_encode($request->all()));

            $resource = app()->make(AdminUpdateResource::class, ['resource' => $request])->toArray($request);

            $updatedRowCount = $this->adminsRepository->updateAdminData($resource, $id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'updatedRowCount: ' . json_encode($updatedRowCount));

            // 権限情報の更新
            $roleIdResource = app()->make(AdminsRolesUpdateResource::class, ['resource' => $request])->toArray($request);
            $updatedAdminsRolesRowCount = $this->adminsRolesRepository->updateAdminsRoleData($roleIdResource, $id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'roleIdResource: ' . json_encode($roleIdResource));
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'updated row: ' . json_encode($updatedAdminsRolesRowCount));

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
     * delete member data service
     *
     * @param  \App\Http\Requests\MemberDeleteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMember(MemberDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;

            $resource = app()->make(AdminDeleteResource::class, ['resource' => $request])->toArray($request);

            $deleteRowCount = $this->adminsRepository->deleteAdminData($resource, $request->id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'deleteRowCount: ' . json_encode($deleteRowCount));

            // 権限情報の更新
            $roleIdResource = app()->make(AdminsRolesDeleteResource::class, ['resource' => $request])->toArray($request);
            $deleteAdminsRolesRowCount = $this->adminsRolesRepository->deleteAdminsRoleData($roleIdResource, $id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'roleIdResource: ' . json_encode($roleIdResource));
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'delete row: ' . json_encode($deleteAdminsRolesRowCount));

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
