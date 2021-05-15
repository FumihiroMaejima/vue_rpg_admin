<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\MembersController;
use App\Http\Controllers\Admins\AuthController as AdminAuthController;
use App\Http\Controllers\Admins\AuthInfoController;
use App\Http\Controllers\Admins\PermissionsController;
use App\Http\Controllers\Admins\RolesController;
use App\Http\Controllers\Admins\Game\EnemiesController;
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
Route::group(['prefix' => 'v1/auth/admin'], function () {
    Route::post('login', [AdminAuthController::class, 'login'])->name('auth.admin');
});

// admin auth
Route::group(['prefix' => 'v1/auth/admin', 'middleware' => 'auth:api-admins'], function () {
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::post('refresh', [AdminAuthController::class, 'refresh']);
    Route::post('self', [AdminAuthController::class, 'getAuthUser']);
});

// admin
Route::group(['prefix' => 'v1/admin', 'middleware' => 'auth:api-admins'], function () {
    // auth info
    Route::get('/authinfo', [AuthInfoController::class, 'index']);

    // members
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', [MembersController::class, 'index'])->name('admin.members.index');
        Route::get('/csv', [MembersController::class, 'download'])->name('admin.members.download');
        Route::post('/member', [MembersController::class, 'create'])->name('admin.members.create');
        Route::patch('/member/{id}', [MembersController::class, 'update'])->name('admin.members.update');
        Route::delete('/member/{id}', [MembersController::class, 'destroy'])->name('admin.members.delete');
    });

    // roles
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RolesController::class, 'index'])->name('admin.roles.index');
        Route::get('/list', [RolesController::class, 'list'])->name('admin.roles.list');
        Route::get('/csv', [RolesController::class, 'download'])->name('admin.roles.download');
        Route::post('/role', [RolesController::class, 'create'])->name('admin.roles.create');
        Route::patch('/role/{id}', [RolesController::class, 'update'])->name('admin.roles.update');
        Route::delete('/role', [RolesController::class, 'destroy'])->name('admin.roles.delete');
    });

    // permissions
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/list', [PermissionsController::class, 'list'])->name('admin.permissions.list');
    });

    // game
    Route::group(['prefix' => 'game'], function () {
        // enemies
        Route::group(['prefix' => 'enemies'], function () {
            Route::get('/', [EnemiesController::class, 'index'])->name('admin.game.enemies.index');
            Route::get('/file/csv', [EnemiesController::class, 'download'])->name('admin.game.enemies.download');
            Route::get('/file/template', [EnemiesController::class, 'template'])->name('admin.game.enemies.template');
            Route::post('/file/template', [EnemiesController::class, 'uploadTemplate'])->name('admin.game.enemies.template.upload');
            Route::patch('/enemy/{id}', [EnemiesController::class, 'update'])->name('admin.game.enemies.update');
            Route::delete('/enemy', [EnemiesController::class, 'destroy'])->name('admin.game.enemies.delete');
        });
    });
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
