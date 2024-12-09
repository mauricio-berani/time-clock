<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\{Permission, Role};
use Illuminate\Support\Str;
use App\Enums\Auth\{Permissions, Roles};
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissionsEmployee          = [
            Permissions::MOUNT_DASHBOARD->value,
            Permissions::MOUNT_PROFILE->value,
            Permissions::UPDATE_PROFILE->value,
            Permissions::MOUNT_CLOCK->value,
            Permissions::FIND_ALL_CLOCK->value,
            Permissions::FIND_ONE_CLOCK->value,
            Permissions::LIST_CLOCK->value,
            Permissions::UPDATE_CLOCK->value,
            Permissions::DELETE_CLOCK->value,
            Permissions::CREATE_CLOCK->value,
        ];
        $permissionsAdministrator = array_merge([
            Permissions::MOUNT_USER->value,
            Permissions::FIND_ALL_USER->value,
            Permissions::FIND_ONE_USER->value,
            Permissions::LIST_USER->value,
            Permissions::UPDATE_USER->value,
            Permissions::DELETE_USER->value,
            Permissions::CREATE_USER->value,
        ], $permissionsEmployee);


        $permissions = $permissionsAdministrator;

        foreach ($permissions as $permission) {

            if (Permission::where('name', $permission)->first())
                Permission::where('name', $permission)->delete();

            Permission::create([
                'id' => (string) Str::uuid(),
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $roles = [
            Roles::EMPLOYEE->value      => $permissionsEmployee,
            Roles::ADMINISTRATOR->value => $permissionsAdministrator,
        ];

        foreach ($roles as $roleName => $rolePermissions) {

            if (Role::where('name', $roleName)->first())
                Role::where('name', $roleName)->delete();

            $role = Role::create([
                'id' => (string) Str::uuid(),
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
