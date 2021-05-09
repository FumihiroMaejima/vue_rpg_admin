<?php

namespace App\Services\Game;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
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
use App\Http\Requests\Game\EnemiesDeleteRequest;
use App\Http\Requests\Game\EnemiesImportRequest;
use App\Http\Requests\Game\EnemiesUpdateRequest;
use App\Http\Resources\Game\GameEnemiesCreateResource;
use App\Http\Resources\Game\GameEnemiesDeleteResource;
use App\Http\Resources\Game\GameEnemiesServiceResource;
use App\Http\Resources\Game\GameEnemiesUpdateResource;
use App\Exports\Game\EnemiesExport;
use App\Exports\Game\EnemiesTemplateExport;
use App\Imports\Game\EnemiesImport;
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
     * download enemies csv data service
     *
     * @param  \Illuminate\Http\Request;  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadCSV(Request $request)
    {
        $data = $this->enemiesRepository->getGameEnemies();

        return Excel::download(new EnemiesExport($data), 'game_enemies_info_' . Carbon::now()->format('YmdHis') . '.csv');
    }

    /**
     * download enemies template data service
     *
     * @param  \Illuminate\Http\Request;  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate(Request $request)
    {
        return Excel::download(new EnemiesTemplateExport(collect(Config::get('myapp.game.template.enemies'))), 'game_enemies_template_' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    /**
     * imort enemies by template data service
     *
     * @param  \App\Http\Requests\Game\EnemiesImportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function importTemplate(EnemiesImportRequest $request)
    {
        // Illuminate\Http\UploadedFile
        $file = $request->file;

        // ファイル名チェック
        if (!preg_match('/^game_enemies_template_\d{14}\.xlsx/u', $file->getClientOriginalName())) {
            throw (new HttpResponseException(response()->json([
                'status'  => 422,
                'errors'  => [],
                'message' => 'no inclued title'
            ], 422)));
        }

        DB::beginTransaction();
        try {
            // Excel::import(new EnemiesImport, $file, null, \Maatwebsite\Excel\Excel::XLSX);
            // Excel::import(new EnemiesImport($file), $file, null, \Maatwebsite\Excel\Excel::XLSX);
            $fileData = Excel::toArray(new EnemiesImport($file), $file, null, \Maatwebsite\Excel\Excel::XLSX);

            $resource = app()->make(GameEnemiesCreateResource::class, ['resource' => $fileData[0]])->toArray($request);

            $isInsert = $this->enemiesRepository->createGameEnemies($resource);

            DB::commit();

            // レスポンスの制御
            $message = ($isInsert > 0) ? 'success' : 'Bad Request';
            $status = ($isInsert > 0) ? 201 : 401;

            return response()->json(['message' => $message, 'status' => $status], $status);

        } catch (Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }

    /**
     * update enemy data service
     *
     * @param  \App\Http\Requests\Gamee\EnemiesUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEnemyData(EnemiesUpdateRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $resource = app()->make(GameEnemiesUpdateResource::class, ['resource' => $request])->toArray($request);

            $updatedRowCount = $this->enemiesRepository->updateGameEnemiesData($resource, $id);

            // slack通知
            /* $attachmentResource = app()->make(RoleUpdateNotificationResource::class, ['resource' => ":tada: Update Role Data \n"])->toArray($request);
            app()->make(RoleSlackNotificationService::class)->send('update role data.', $attachmentResource); */

            DB::commit();

            // 更新されていない場合は304
            $message = ($updatedRowCount > 0) ? 'success' : 'not modified';
            $status = ($updatedRowCount > 0) ? 200 : 304;

            return response()->json(['message' => $message, 'status' => $status], $status);
        } catch (Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }

    /**
     * delete enemies data service
     *
     * @param  \App\Http\Requests\Game\EnemiesDeleteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEnemy(EnemiesDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $enemyIds = $request->enemies;

            $resource = app()->make(GameEnemiesDeleteResource::class, ['resource' => $request])->toArray($request);

            $deleteRowCount = $this->enemiesRepository->deleteGameEnemiesData($resource, $enemyIds);

            DB::commit();

            // 更新されていない場合は304
            $message = ($deleteRowCount > 0) ? 'success' : 'not deleted';
            $status = ($deleteRowCount > 0) ? 200 : 401;

            return response()->json(['message' => $message, 'status' => $status], $status);
        } catch (Exception $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'message: ' . json_encode($e->getMessage()));
            DB::rollback();
            abort(500);
        }
    }
}
