<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GamePlayerLogTableSeeder extends Seeder
{
    private $table = 'game_player_log';
    private $count = 6;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            'player_id' => 1,
            'function' => 'test function',
            'status' => Str::random(20),
            'action_time' => '2021-01-14 00:00:00',
            'created_at' => '2021-01-14 00:00:00',
            'updated_at' => '2021-01-14 00:00:00'
        ];

        // insert用データ
        $data = [];

        // 0~12の数字の配列でforを回す
        foreach (range(1, $this->count) as $i) {
            $row = $template;
            $row['function'] = $row['function']  . '_' . (string)($i);
            $row['status'] = $row['status']  . '_' . (string)($i);

            $data[] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
