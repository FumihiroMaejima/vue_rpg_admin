<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Http\Resources\AdminsCollection;
use App\Http\Resources\AdminsResource;
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

    public function updateMemberData(Request $request, int $id)
    {
        DB::beginTransaction();
        try{
            /* $request->keys();           // ["id","name","email","roleId"]
            $request->input('name');    // 'admin124234 */
            $data = $this->adminsRepository->getAdminsList();
            // $data = $this->adminsRepository->updateAdminData();
            // サービスコンテナからリソースクラスインスタンスを依存解決
            // コンストラクタのresourceに割り当てる値を渡す
            $resourceCollection = app()->make(AdminsCollection::class, ['resource' => $data]);
            // $resource = app()->make(AdminsResource::class, ['resource' => $data]);
            DB::commit();
        }
        catch(Exception $e) {
            DB::rollback();
            abort(500);
        }

        return response()->json($resourceCollection->toArray($request), 200);
        // return response()->json($resource->toArray($request), 200);
    }
}
