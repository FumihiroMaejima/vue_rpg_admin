<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Services\MembersService;
use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Http\Requests\MemberDeleteRequest;
use App\Trait\CheckHeaderTrait;
use Illuminate\Support\Facades\Config;

class MembersController extends Controller
{
    use CheckHeaderTrait;
    private $service;

    /**
     * Create a new MembersController instance.
     *
     * @return void
     */
    public function __construct(MembersService $membersService)
    {
        $this->middleware('auth:api-admins');
        $this->service = $membersService;
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
        if (!$this->checkRequestAuthority($request, Config::get('myapp.executionRole.services.members'))) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // 処理速度の計測
        $time_start = microtime(true);

        // サービスの実行
        $response = $this->service->getAdmins($request);

        $time = microtime(true) - $time_start;
        // PHPによって割り当てられたメモリの最大値の取得
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'peak usage memory size: ' . (string)memory_get_peak_usage());
        // サービス処理の実行時間の取得
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'service execution time: ' . (string)$time);
        return $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        // 権限チェック
        if (!$this->checkRequestAuthority($request, Config::get('myapp.executionRole.services.members'))) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // 処理速度の計測
        $time_start = microtime(true);

        // サービスの実行
        $response = $this->service->downloadCSV($request);

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
     * @param  \App\Http\Requests\MemberCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(MemberCreateRequest  $request)
    {
        // 処理速度の計測
        $time_start = microtime(true);

        // サービスの実行
        $response = $this->service->createMember($request);

        $time = microtime(true) - $time_start;
        // PHPによって割り当てられたメモリの最大値の取得
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'peak usage memory size: ' . (string)memory_get_peak_usage());
        // サービス処理の実行時間の取得
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'service execution time: ' . (string)$time);
        return $response;
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
     * @param  \App\Http\Requests\MemberUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberUpdateRequest $request, int $id)
    {
        // 処理速度の計測
        $time_start = microtime(true);

        // サービスの実行
        $response = $this->service->updateMemberData($request, $id);

        $time = microtime(true) - $time_start;
        // PHPによって割り当てられたメモリの最大値の取得
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'peak usage memory size: ' . (string)memory_get_peak_usage());
        // サービス処理の実行時間の取得
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'service execution time: ' . (string)$time);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\MemberUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberDeleteRequest $request)
    {
        // 処理速度の計測
        $time_start = microtime(true);

        // サービスの実行
        $response = $this->service->deleteMember($request);

        $time = microtime(true) - $time_start;
        // PHPによって割り当てられたメモリの最大値の取得
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'peak usage memory size: ' . (string)memory_get_peak_usage());
        // サービス処理の実行時間の取得
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'service execution time: ' . (string)$time);
        return $response;
    }
}
