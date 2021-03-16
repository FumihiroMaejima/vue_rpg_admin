<?php

namespace Tests\Unit\Service;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class MemberServiceTest extends TestCase
{
    protected $initialized = false;

    /**
     * 初期化処理
     *
     * @return array
     */
    protected function init(): array
    {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');

        $response = $this->json('POST', route('auth.admin'), [
            'email' => Config::get('myapp.test.admin.login.email'),
            'password' => Config::get('myapp.test.admin.login.password')
        ])->json();

        return [
            'token' => $response['access_token'],
            'user_id' => $response['user']['id']
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
            'Authorization' => 'Bearer ' . $loginUser['token'],
        ]);
    }

    /**
     * members get request test.
     *
     * @return void
     */
    public function testGetMembers(): void
    {
        $response = $this->get(route('admin.members.index'));
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    /**
     * member data
     * @param int id
     * @param string name
     * @param string email
     * @param int roleId
     */
    public function memberDataProvider(): array
    {
        return [
            'member' => [1, 'test name', Config::get('myapp.test.admin.login.email'), 1]
        ];
    }

    /**
     * members update request test.
     *
     * @return void
     */
    public function testUpdateMembers(): void
    {
        $response = $this->json('PATCH', route('admin.members.update', ['id' => 1]), [
            'name' => 'test name',
            'email' => Config::get('myapp.test.admin.login.email'),
            'roleId' => 1
        ]);
        $response->assertStatus(200);
    }

    /**
     * members update request failed test.
     *
     * @return void
     */
    public function testUpdateFailedMembers(): void
    {
        $response = $this->json('PATCH', route('admin.members.update', ['id' => 1]), [
            'name' => '',
            'email' => Config::get('myapp.test.admin.login.email'),
            'roleId' => 1
        ]);
        $response->assertStatus(422);
    }
}
