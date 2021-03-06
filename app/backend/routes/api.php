<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\MembersController;
use App\Http\Controllers\Admins\AuthController as AdminAuthController;
use App\Http\Controllers\Admins\AuthInfoController;
use App\Http\Controllers\Admins\RolesController;
use App\Http\Controllers\Users\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// api test
Route::get('test', function () {
    return 'api connection test!';
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth/admin'], function () {
    Route::post('login', [AdminAuthController::class, 'login']);
});

// admin auth
Route::group(['prefix' => 'auth/admin', 'middleware' => 'auth:api-admins'], function () {
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::post('refresh', [AdminAuthController::class, 'refresh']);
    Route::post('self', [AdminAuthController::class, 'getAuthUser']);
});

// admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api-admins'], function () {
    // auth info
    Route::get('/authinfo', [AuthInfoController::class, 'index']);

    // members
    Route::get('/members', [MembersController::class, 'index']);

    // roles
    Route::get('/roles', [RolesController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

// user auth
Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('self', [AuthController::class, 'getAuthUser']);
});
