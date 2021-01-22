<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GamePlayerItemListTableSeeder extends Seeder
{
    private $table = 'game_player_item_list';
    private $count = 3;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            'player_id' => 1,
            'content1' => 1,
            'content2' => null,
            'content3' => null,
            'content4' => null,
            'content5' => null,
            'content6' => null,
            'content7' => null,
            'content8' => null,
            'content9' => null,
            'content10' => null,
            'content11' => null,
            'content12' => null,
            'content13' => null,
            'content14' => null,
            'content15' => null,
            'content16' => null,
            'content17' => null,
            'content18' => null,
            'content19' => null,
            'content20' => null,
            'created_at' => '2021-01-14 00:00:00',
            'updated_at' => '2021-01-14 00:00:00'
        ];

        // insert用データ
        $data = [];

        // 0~12の数字の配列でforを回す
        foreach (range(1, $this->count) as $i) {
            $row = $template;
            $row['player_id'] = ($i + 1);

            $data[] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
