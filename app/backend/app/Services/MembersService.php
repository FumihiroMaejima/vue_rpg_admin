<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Http\Resources\AdminsCollection;

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
        // コンストラクタにresourceに割り当てる値を渡す
        $collection = app()->make(AdminsCollection::class, ['resource' => $data]);
        $test = $collection->toArray($request);

        return $this->adminsRepository->getAdmins();
    }
}
