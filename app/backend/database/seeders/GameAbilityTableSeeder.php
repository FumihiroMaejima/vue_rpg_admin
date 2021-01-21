<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GameAbilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 配列内の要素は、object型への変換によってstdClassを作成する
        $seedData = [
            (object)['name' => 'ablity1', 'value' => 10],
            (object)['name' => 'ablity2', 'value' => 20],
            (object)['name' => 'ablity3', 'value' => 30],
            (object)['name' => 'ablity4', 'value' => 40],
            (object)['name' => 'ablity5', 'value' => 50]
        ];

        // テーブルへの格納
        foreach ($seedData as $key => $data) {
            DB::table('game_ability')->insert([
                'name' => $data->name,
                'target_column1' => Str::random(20) . '_' . $key,
                'target_effect1' => $data->value,
                'target_column2' => Str::random(20) . '_' . $key,
                'target_effect2' => $data->value,
                'message' => 'this ability message' . Str::random(40),
                'created_at' => '2021-01-14 00:00:00',
                'updated_at' => '2021-01-14 00:00:00'
            ]);
        }
    }
}
