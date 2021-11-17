<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    private $table = 'users';
    private $count = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            'name'       => '',
            'email'      => '',
            'password'   => bcrypt(Config::get('myapp.seeder.password.testuser')),
            'role'       => 10,
            'created_at' => '2021-05-14 00:00:00',
            'updated_at' => '2021-05-14 00:00:00'
        ];

        // insert用データ
        $data = [];

        // 0~12の数字の配列でforを回す
        foreach (range(1, $this->count) as $i) {
            $row          = $template;
            $row['name']  = 'user' . (string)($i);
            $row['email'] = 'testuser' . (string)($i) . '@example.com';

            $data[] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
