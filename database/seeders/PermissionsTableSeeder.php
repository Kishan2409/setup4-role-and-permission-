<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            //Users
            ['name' => 'Can View Users', 'slug' => 'view.user', 'description' => 'Can view users', 'model' => 'User',],
            ['name' => 'Can Create Users', 'slug' => 'create.user', 'description' => 'Can create new users', 'model' => 'User',],
            ['name' => 'Can Edit Users', 'slug' => 'edit.user', 'description' => 'Can edit users', 'model' => 'User',],
            ['name' => 'Can Delete Users', 'slug' => 'delete.user', 'description' => 'Can delete users', 'model' => 'User',],
            //Clients
            ['name' => 'Can View Clients', 'slug' => 'view.client', 'description' => 'Can view clients', 'model' => 'Client',],
            ['name' => 'Can Create Clients', 'slug' => 'create.client', 'description' => 'Can create new clients', 'model' => 'Client',],
            ['name' => 'Can Edit Clients', 'slug' => 'edit.client', 'description' => 'Can edit clients', 'model' => 'Client',],
            ['name' => 'Can Delete Clients', 'slug' => 'delete.client', 'description' => 'Can delete clients', 'model' => 'Client',],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
