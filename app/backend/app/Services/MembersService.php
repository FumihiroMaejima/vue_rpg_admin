<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Http\Resources\AdminsCollection;
use App\Http\Resources\AdminsResource;
use Illuminate\Support\Facades\Log;
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
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'request all: ' . json_encode($request->all()));
            $data = $this->adminsRepository->updateAdminData($request, $id);
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'data: ' . json_encode($data));

            DB::commit();

            return response()->json(['message' => $data > 0 ? 'success' : 'not modified'], $data > 0 ? 200 : 304);
        }
        catch(Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'data: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
        // return response()->json(['message' => 'success'], 200);
    }
}
