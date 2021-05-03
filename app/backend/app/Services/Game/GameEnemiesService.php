<?php

namespace App\Services\Game;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Services\Notifications\RoleSlackNotificationService;
use App\Repositories\Roles\RolesRepositoryInterface;
use App\Repositories\RolePermissions\RolePermissionsRepositoryInterface;
use App\Repositories\GameEnemies\GameEnemiesRepository;
use App\Repositories\GameEnemies\GameEnemiesRepositoryInterface;
use App\Http\Resources\RoleUpdateResource;
use App\Http\Resources\RoleUpdateNotificationResource;
use App\Http\Resources\RolesServiceResource;
use App\Http\Resources\RolesListResource;
use App\Http\Resources\RolePermissionsUpdateResource;
use App\Http\Resources\RolePermissionsDeleteResource;
use App\Http\Resources\RolePermissionsDeleteByUpdateResource;
use App\Http\Resources\RolePermissionsCreateResource;
use App\Http\Resources\RoleDeleteResource;
use App\Http\Resources\RoleCreateResource;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Requests\RoleDeleteRequest;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Resources\Game\GameEnemiesServiceResource;
use App\Exports\RolesExport;
use Exception;

class GameEnemiesService
{
    protected $enemiesRepository;

    /**
     * create GameEnemiesService instance
     * @param  \App\Repositories\GameEnemies\GameEnemiesRepositoryInterface  $rolesRepository
     * @return void
     */
    public function __construct(GameEnemiesRepositoryInterface $enemiesRepository)
    {
        $this->enemiesRepository = $enemiesRepository;
    }

    /**
     * get roles data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEnemies(Request $request)
    {
        $collection = $this->enemiesRepository->getGameEnemies();
        $resourceCollection = app()->make(GameEnemiesServiceResource::class, ['resource' => $collection]);

        return response()->json($resourceCollection->toArray($request), 200);
    }

    /**
     * download role data service
     *
     * @param  \Illuminate\Http\Request;  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    /* public function downloadCSV(Request $request)
    {
        $data = $this->enemiesRepository->getEnemies();

        return Excel::download(new RolesExport($data), 'roles_info_' . Carbon::now()->format('YmdHis') . '.csv');
    } */
}
