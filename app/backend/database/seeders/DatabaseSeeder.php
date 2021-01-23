<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(AdminsLogTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RolePermissionsTableSeeder::class);
        $this->call(AdminsRolesTableSeeder::class);
        $this->call(GameAbilityTableSeeder::class);
        $this->call(GameAreaTableSeeder::class);
        $this->call(GameDiffenseEquipmentTableSeeder::class);
        $this->call(GameOffenceEquipmentTableSeeder::class);
        $this->call(GameEnemyTableSeeder::class);
        $this->call(GameCharacterTableSeeder::class);
        $this->call(GameEventTableSeeder::class);
        $this->call(GameItemTableSeeder::class);
        $this->call(GameTitleTableSeeder::class);
        $this->call(GamePlayerTableSeeder::class);
        $this->call(GamePlayerLogTableSeeder::class);
        $this->call(GamePlayerItemListTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
