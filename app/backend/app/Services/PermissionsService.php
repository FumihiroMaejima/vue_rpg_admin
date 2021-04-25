<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Permissions\PermissionsRepositoryInterface;
use App\Http\Resources\PermissionsListResource;


class PermissionsService
{
    protected $permissionsRepository;

    public function __construct(PermissionsRepositoryInterface $permissionsRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
    }

    public function getPermissionsList(Request $request)
    {
        $collection = $this->permissionsRepository->getPermissionsList();
        $resource = app()->make(PermissionsListResource::class, ['resource' => $collection]);

        return response()->json($resource->toArray($request), 200);
    }
}
