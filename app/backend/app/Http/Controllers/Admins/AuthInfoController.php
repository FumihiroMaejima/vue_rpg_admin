<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use App\Services\AuthInfoService;

class AuthInfoController extends Controller
{
    protected $admin;

    /**
     * Create a new AuthInfoController instance.
     *
     * @return void
     */
    public function __construct(AuthInfoService $authInfoService)
    {
        $this->middleware('auth:api-admins');
        $this->admin = $authInfoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        // 処理速度の計測
        $time_start = microtime(true);
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'log test message.');
        $test = $this->admin->getAdminInfo();
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'repository test: ' . $test);
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'repository get_class($test->admin): ' . get_class($this->admin));
        // PHPによって割り当てられたメモリの最大値の取得
        Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'log test memory_get_peak_usage: ' . (string)memory_get_peak_usage());
        $time = microtime(true) - $time_start;
        Log::debug(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'debug time message: ' . (string)$time);
        return response()->json(auth('api-admins')->user());
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
