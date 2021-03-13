<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RolesTableSeeder extends Seeder
{
    private $table = 'roles';
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
            'created_at' => '2021-01-14 00:00:00',
            'updated_at' => '2021-01-14 00:00:00'
        ];

        $dataList = Config::get('local.seeder.authority.rolesNameList');

        // insert用データ
        $data = [];

        // 0~12の数字の配列でforを回す
        foreach (range(1, $this->count) as $i) {
            $row = $template;
            $row['name'] = $dataList[$i - 1];

            $data[] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
