<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use App\Enums\Auth\Roles;
use App\Models\Auth\Role;

class AdministratorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AdministratorRole = Role::where('name', Roles::ADMINISTRATOR->value)->first();


        if (User::where('email', config('admin.email'))->first())
            User::where('email', config('admin.email'))->delete();

        $administratorUser = User::create([
            'id'       => (string) Str::uuid(),
            'name'     => config('admin.name'),
            'document' => config('admin.document'),
            'email'    => config('admin.email'),
            'password' => config('admin.password'),
        ]);
        $administratorUser->assignRole($AdministratorRole);
    }
}
