<?php

use Database\Seeders\AdministratorUserSeeder;
use Database\Seeders\PermissionRoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionRoleSeeder::class,
            AdministratorUserSeeder::class,
        ]);
    }
}
