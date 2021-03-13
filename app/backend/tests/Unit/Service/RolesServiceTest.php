<?php

namespace Tests\Unit\Service;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use \Illuminate\Http\Response;

class RolesServiceTest extends TestCase
{
    protected $initialized = false;

    /**
     * 初期化処理
     *
     * @return array
     */
    protected function init(): array
    {

        // 'testing'
        // $env = Config::get('app.env');

        /* Artisan::call('migrate:refresh');
        Artisan::call('deb:seed --class =DatabaseSeeder'); */

        $response = json_decode($this->json('POST', route('auth.admin'), [
            'email' => Config::get('local.test.admin.login.email'),
            'password' => Config::get('local.test.admin.login.password')
        ])->baseResponse->content());

        return [
            'token' => $response->access_token,
            'user_id' => $response->user->id
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
            $loginUser = $this->init();
            $this->initialized = true;
        }


        $this->withHeaders([
            'X-Auth-ID' => $loginUser['user_id'],
            'Authorization' => 'Bearer '. $loginUser['token'],
         ]);
    }

    /**
     * roles get request test.
     *
     * @return void
     */
    public function testGetRoles()
    {
        $response = $this->get(route('admin.roles.index'));
        $response->assertStatus(200);
    }
}
