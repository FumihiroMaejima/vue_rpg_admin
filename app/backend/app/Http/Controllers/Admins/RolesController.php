<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\RolesService;
use App\Trait\CheckHeaderTrait;
use Illuminate\Support\Facades\Config;

class RolesController extends Controller
{
    use CheckHeaderTrait;
    private $service;

    /**
     * Create a new RolesController instance.
     *
     * @return void
     */
    public function __construct(RolesService $rolesService)
    {
        $this->middleware('auth:api-admins');
        $this->service = $rolesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index(Request $request)
    {
        // 権限チェック
        if (!$this->checkRequestAuthority($request, Config::get('myapp.executionRole.services.roles'))) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // 処理速度の計測
        $time_start = microtime(true);

        // サービスの実行
        $response = $this->service->getRoles($request);

        $time = microtime(true) - $time_start;
        // PHPによって割り当てられたメモリの最大値の取得
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'peak usage memory size: ' . (string)memory_get_peak_usage());
        // サービス処理の実行時間の取得
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'service execution time: ' . (string)$time);
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
