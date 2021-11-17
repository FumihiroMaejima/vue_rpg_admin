<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GameAreaTableSeeder extends Seeder
{
    private $table = 'game_area';
    private $count = 12;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            'name' => '',
            'message' => 'this area message' . Str::random(40),
            'image_name' => Str::random(20),
            'image_url' => 'https://' . Str::random(20),
            'created_at' => '2021-01-14 00:00:00',
            'updated_at' => '2021-01-14 00:00:00'
        ];

        // insert用データ
        $data = [];

        // 0~12の数字の配列でforを回す
        foreach (range(1, $this->count) as $i) {
            $row = $template;
            $row['name'] = 'area' . (string)($i);
            $row['message'] = $row['message']  . '_' . (string)($i);
            $row['image_name'] = $row['image_name']  . '_' . (string)($i);
            $row['image_url'] = $row['image_url']  . '_' . (string)($i);

            $data[] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
