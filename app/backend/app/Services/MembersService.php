<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Repositories\AdminsRoles\AdminsRolesRepositoryInterface;
use App\Http\Resources\AdminsCollection;
use App\Http\Resources\AdminsResource;
use App\Http\Resources\AdminUpdateResource;
use App\Http\Resources\AdminsRolesUpdateResource;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MemberUpdateRequest;
use Exception;

class MembersService
{
    protected $adminsRepository;

    public function __construct(AdminsRepositoryInterface $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
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
     * @param  \App\Http\Requests\MemberUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMemberData(MemberUpdateRequest $request, int $id)
    {
        DB::beginTransaction();
        try{
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'request all: ' . json_encode($request->all()));

            $resource = app()->make(AdminUpdateResource::class, ['resource' => $request])->toArray($request);

            $updatedRowCount = $this->adminsRepository->updateAdminData($resource, $id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'updatedRowCount: ' . json_encode($updatedRowCount));

            // 権限情報の更新
            $roleIdResource = app()->make(AdminsRolesUpdateResource::class, ['resource' => $request])->toArray($request);
            $updatedAdminsRolesRowCount = app()->make(AdminsRolesRepositoryInterface::class)->updateAdminsRoleData($roleIdResource, $id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'roleIdResource: ' . json_encode($roleIdResource));
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'updated row: ' . json_encode($updatedAdminsRolesRowCount));

            DB::commit();

            // 更新されて以内場合は304
            $message = ($updatedRowCount > 0 || $updatedAdminsRolesRowCount > 0) ? 'success' : 'not modified';
            $status = ($updatedRowCount > 0 || $updatedAdminsRolesRowCount > 0) ? 200 : 304;

            return response()->json(['message' => $message, 'status' => $status], $status);
        }
        catch(Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }
}
