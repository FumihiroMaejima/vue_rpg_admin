<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Http\Resources\AdminsCollection;
use App\Http\Resources\AdminsResource;

class MembersService
{
    protected $adminsRepository;

    public function __construct(AdminsRepositoryInterface $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
    }

    public function getAdmins(Request $request)
    {
        $data = $this->adminsRepository->getAdmins();
        // サービスコンテナからリソースクラスインスタンスを依存解決
        // コンストラクタのresourceに割り当てる値を渡す
        $collection = app()->make(AdminsCollection::class, ['resource' => $data]);
        $resource = app()->make(AdminsResource::class, ['resource' => $data]);

        $test1 = $collection->toArray($request);
        $test2 = $resource->toArray($request);

        // return $this->adminsRepository->getAdmins();
        return response()->json($resource->toArray($request), 200);
    }
}
