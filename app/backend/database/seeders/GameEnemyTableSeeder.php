<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GameEnemyTableSeeder extends Seeder
{
    private $table = 'game_enemy';
    private $count = 12;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            'name'                  => '',
            'level'                 => 1,
            'hp'                    => 30,
            'mp'                    => 10,
            'offence'               => 10,
            'diffense'              => 10,
            'speed'                 => 10,
            'magic'                 => 10,
            'offence_equipment_id'  => 1,
            'diffense_equipment_id' => 1,
            'ability1_id'           => 1,
            'ability2_id'           => 1,
            'ability3_id'           => 1,
            'item'                  => 'item',
            'event_only_flg'        => 0,
            'emcount_area_id'       => 1,
            'image_name'            => Str::random(20),
            'image_url'             => 'https://' . Str::random(20),
            'created_at'            => '2021-01-14 00:00:00',
            'updated_at'            => '2021-01-14 00:00:00'
        ];

        // insert用データ
        $data[] = [];

        // 0~12の数字の配列でforを回す
        foreach (range(0, $this->count) as $i) {
            $row = $template;
            $row['name'] = 'enemy' . (string)($i);
            $row['hp'] = $row['hp'] + (10 * $i);
            $row['mp'] = $row['mp'] + (10 * $i);
            $row['offence'] = $row['offence'] + (10 * $i);
            $row['diffense'] = $row['diffense'] + (5 * $i);
            $row['speed'] = $row['speed'] + (10 * $i);
            $row['magic'] = $row['magic'] + (2 * $i);
            $row['image_name'] = $row['image_name']  . '_' . (string)($i);
            $row['image_url'] = $row['image_url']  . '_' . (string)($i);

            $data[$i] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
