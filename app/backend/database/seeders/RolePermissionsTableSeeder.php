<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RolePermissionsTableSeeder extends Seeder
{
    private $table = 'role_permissions';
    private $count = 12;
    private $masterCount = 4;
    private $adminCount = 8;
    private $developCount = 11;
    private $readOnlyCount = 12;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            'name'          => '',
            'role_id'       => 1,
            'permission_id' => 1,
            'created_at'    => '2021-01-14 00:00:00',
            'updated_at'    => '2021-01-14 00:00:00'
        ];

        $roles = Config::get('myapp.seeder.authority.roles');

        $permissions = Config::get('myapp.seeder.authority.permissions');

        // insert用データ
        $data = [];

        // 0~12の数字の配列でforを回す
        foreach (range(1, $this->count) as $i) {
            $row = $template;

            // ロール順にロールとパーミッションの割り当てを行う
            if ($i <= $this->masterCount) {
                // マスターの場合
                $row['name']          = $roles[0]->name . '_' . $permissions[$i - 1]->name;
                $row['short_name']    = $permissions[$i - 1]->name;
                $row['role_id']       = $roles[0]->key;
                $row['permission_id'] = $permissions[$i - 1]->key;
            } elseif (($this->masterCount < $i) && ($i <= $this->adminCount)) {
                // 管理者の場合
                $row['name']          = $roles[1]->name . '_' . $permissions[$i - 5]->name;
                $row['short_name']    = $permissions[$i - 5]->name;
                $row['role_id']       = $roles[1]->key;
                $row['permission_id'] = $permissions[$i - 5]->key;
            } elseif (($this->adminCount < $i) && ($i <= $this->developCount)) {
                // 開発者の場合
                $row['name']          = $roles[2]->name . '_' . $permissions[$i - 9]->name;
                $row['short_name']    = $permissions[$i - 9]->name;
                $row['role_id']       = $roles[2]->key;
                $row['permission_id'] = $permissions[$i - 9]->key;
            } elseif (($i === $this->readOnlyCount)) {
                // 読取専用の場合
                $row['name']          = $roles[3]->name . '_' . $permissions[1]->name;
                $row['short_name']    = $permissions[1]->name;
                $row['role_id']       = $roles[3]->key;
                $row['permission_id'] = $permissions[1]->key;
            }

            $data[] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
