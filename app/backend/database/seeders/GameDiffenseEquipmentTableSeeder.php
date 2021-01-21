<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GameDiffenseEquipmentTableSeeder extends Seeder
{
    private $table = 'game_diffense_equipment';
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
            'message' => 'this diffense equipment message' . Str::random(40),
            'target_column1' => Str::random(20),
            'target_effect1' => 0,
            'target_column2' => Str::random(20),
            'target_effect2' => 0,
            'image_name' => Str::random(20),
            'image_url' => 'https://' . Str::random(20),
            'created_at' => '2021-01-14 00:00:00',
            'updated_at' => '2021-01-14 00:00:00'
        ];

        // insert用データ
        $data[] = [];

        // 0~12の数字の配列でforを回す
        foreach (range(0, $this->count) as $i) {
            $row = $template;
            $row['name'] = 'diffense equipment' . (string)($i);
            $row['message'] = $row['message']  . '_' . (string)($i);
            $row['target_column1'] = $row['target_column1']  . '_' . (string)($i);
            $row['target_effect1'] = ($i + 1) * 1;
            $row['target_column2'] = $row['target_column2']  . '_' . (string)($i);
            $row['target_effect2'] = ($i + 1) * 1;
            $row['image_name'] = $row['image_name']  . '_' . (string)($i);
            $row['image_url'] = $row['image_url']  . '_' . (string)($i);

            $data[$i] = $row;
        }

        // テーブルへの格納
        DB::table($this->table)->insert($data);
    }
}
