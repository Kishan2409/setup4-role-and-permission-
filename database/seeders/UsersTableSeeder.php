<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Super admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('mobile_no', '=', '0000000000')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'mobile_no'    => '0000000000',
                'password' => bcrypt('password'),
                'added_by' => '1'
            ]);

            $newUser->attachRole($adminRole);

            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('mobile_no', '=', '1111111111')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'User',
                'mobile_no'    => '1111111111',
                'password' => bcrypt('password'),
                'added_by' => '1'
            ]);

            $newUser->attachRole($userRole);
        }
    }
}
