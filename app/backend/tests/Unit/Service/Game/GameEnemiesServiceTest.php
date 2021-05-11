<?php

namespace Tests\Unit\Service\Game;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Game\EnemiesTemplateExport;

class GameEnemiesServiceTest extends TestCase
{
    protected $initialized = false;
    protected $templateMimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    /**
     * 初期化処理
     *
     * @return array
     */
    protected function init(): array
    {

        // 'testing'
        // $env = Config::get('app.env');

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');

        $response = $this->json('POST', route('auth.admin'), [
            'email'    => Config::get('myapp.test.admin.login.email'),
            'password' => Config::get('myapp.test.admin.login.password')
        ])->json();

        return [
            'token'          => $response['access_token'],
            'user_id'        => $response['user']['id'],
            'user_authority' => $response['user']['authority']
        ];
    }

    /**
     * setUpは各テストメソッドが実行される前に実行する
     * 親クラスのsetUpを必ず実行する
     */
    protected function setUp(): void
    {
        parent::setUp();
        $loginUser = [];

        if (!$this->initialized) {
            $loginUser         = $this->init();
            $this->initialized = true;
        }


        $this->withHeaders([
            'X-Auth-ID'        => $loginUser['user_id'],
            'X-Auth-Authority' => $loginUser['user_authority'],
            'Authorization'    => 'Bearer '. $loginUser['token'],
         ]);
    }

    /**
     * enemies get request test.
     *
     * @return void
     */
    public function testGetEnemies(): void
    {
        $response = $this->get(route('admin.game.enemies.index'));
        $response->assertStatus(200)
            ->assertJsonCount(12, 'data');
    }

    /**
     * enemies file download test.
     * output dir storage/framework/laravel-excel
     *
     * @return void
     */
    public function testDownloadEnemiesCsvFile(): void
    {
        $response = $this->get(route('admin.game.enemies.download'));
        $response->assertStatus(200)
            ->assertHeader('content-type', 'application/csv');
    }

    /**
     * enemies template file download test.
     * output dir storage/framework/laravel-excel
     *
     * @return void
     */
    public function testDownloadEnemiesTemplateFile(): void
    {
        $response = $this->get(route('admin.game.enemies.template'));
        $response->assertStatus(200)
            ->assertHeader('content-type', $this->templateMimeType);
    }

    /**
     * import enemies filee request test.
     *
     * @return void
     */
    public function testImportEnemies(): void
    {
        // \Illuminate\Http\Testing\FileFactory::create()
        // UploadedFile::fake()->createWithContent('game_enemies_template_20210404000000.xlsx', $test);
        // $file = UploadedFile::fake()->create('game_enemies_template_20210404000000.xlsx', 1000, $this->templateMimeType);

        // make file
        $file = Excel::download(new EnemiesTemplateExport(collect(Config::get('myapp.test.game.enemies.template'))), 'game_enemies_template_20210404000000.xlsx')->getFile();
        $response = $this->json('POST', route('admin.game.enemies.template.upload'), [
            'file' => $file
        ]);
        $response->assertStatus(422);
    }


    /**
     * enemies update request test.
     *
     * @return void
     */
    public function testUpdateEnemies(): void
    {
        $response = $this->json('PATCH', route('admin.game.enemies.update', ['id' => 4]), [
            'name'    => 'test name',
            'level'   => 100,
            'hp'      => 100,
            'mp'      => 100,
            'offence' => 100,
            'defense' => 100,
            'speed'   => 100,
            'magic'   => 100
        ]);
        $response->assertStatus(200);
    }

    /**
     * enemies update request failed test.
     *
     * @return void
     */
    public function testUpdateFailedEnemies(): void
    {
        $response = $this->json('PATCH', route('admin.game.enemies.update', ['id' => 4]), [
            'name'    => '',
            'level'   => 0,
            'hp'      => 100,
            'mp'      => 100,
            'offence' => 100,
            'defense' => 100,
            'speed'   => 100,
            'magic'   => 100
        ]);
        $response->assertStatus(422);
    }

    /**
     * enemies delete request test.
     * @return void
     */
    public function testRemoveRoleSuccess(): void
    {
        $response = $this->json('DELETE', route('admin.game.enemies.delete'), [
            'enemies' => [1]
        ]);
        $response->assertStatus(200);
    }

    /**
     * enemies delete data
     * @return array
     */
    public function enemyRemoveValidationErrorDataProvider(): array
    {
        $this->createApplication();

        return [
            'no exist enemies'           => ['enemies' => [100]],
            'not integer value in array' => ['enemies' => ['string']]
        ];
    }

    /**
     * enemies remove validation error test.
     * @dataProvider enemyRemoveValidationErrorDataProvider
     * @return void
     */
    public function testRemoveMemberValidationError(array $roles): void
    {
        $response = $this->json('DELETE', route('admin.game.enemies.delete'), [
            'roles' => $roles
        ]);
        $response->assertStatus(422);
    }
}
