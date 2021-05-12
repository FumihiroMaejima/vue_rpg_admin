<?php

namespace App\Http\Controllers\Admins\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\RolesService;
use App\Services\Game\GameEnemiesService;
use App\Http\Requests\Game\EnemiesDeleteRequest;
use App\Http\Requests\Game\EnemiesImportRequest;
use App\Http\Requests\Game\EnemiesUpdateRequest;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Requests\RoleDeleteRequest;
use App\Trait\CheckHeaderTrait;
use Illuminate\Support\Facades\Config;

class EnemiesController extends Controller
{
    use CheckHeaderTrait;
    private $service;

    /**
     * Create a new RolesController instance.
     *
     * @return void
     */
    public function __construct(GameEnemiesService $enemiesService)
    {
        $this->middleware('auth:api-admins');
        $this->service = $enemiesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index(Request $request)
    {
        // 権限チェック
        if (!$this->checkRequestAuthority($request, Config::get('myapp.executionRole.services.game.enemies'))) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // サービスの実行
        return $this->service->getEnemies($request);
    }

    /**
     * download a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        // 権限チェック
        if (!$this->checkRequestAuthority($request, Config::get('myapp.executionRole.services.game.enemies'))) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // サービスの実行
        return $this->service->downloadCSV($request);
    }

    /**
     * download import template for import the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function template(Request $request)
    {
        // 権限チェック
        if (!$this->checkRequestAuthority($request, Config::get('myapp.executionRole.services.game.enemies'))) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // サービスの実行
        return $this->service->downloadTemplate($request);
    }

    /**
     * import enemies data by file.
     *
     * @param  \App\Http\Requests\Game\EnemiesImportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function uploadTemplate(EnemiesImportRequest  $request)
    {
        // サービスの実行
        return $this->service->importTemplate($request);
    }

    /**
     * creating a new resource.
     *
     * @param  \App\Http\Requests\RoleCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    /* public function create(RoleCreateRequest  $request)
    {
        // サービスの実行
        return $this->service->createRole($request);
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Game\EnemiesUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EnemiesUpdateRequest $request, int $id)
    {
        // サービスの実行
        return $this->service->updateEnemyData($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Game\EnemiesDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnemiesDeleteRequest $request)
    {
        // サービスの実行
        return $this->service->deleteEnemy($request);
    }
}
