<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'admin1',
            'email' => 'testadmin1@example.com',
            'password' => bcrypt(Config::get('local.seeder.password.testadmin')),
            'role' => 100,
            'created_at' => '2020-11-14 00:00:00',
            'updated_at' => '2020-11-14 00:00:00'
        ]);
    }
}
