<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'testadmin',
            'email' => 'testadmin@example.com',
            'password' => bcrypt(Config::get('local.seeder.password.testuser')),
            'role' => 10,
            'created_at' => '2020-11-14 00:00:00',
            'updated_at' => '2020-11-14 00:00:00'
        ]);
    }
}
