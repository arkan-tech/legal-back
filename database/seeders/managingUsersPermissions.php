<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class managingUsersPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $managingUsersRole = Role::findOrCreate('manage-users');

        $readUsersPermission = Permission::findOrCreate('read-users');
        $createUsersPermission = Permission::findOrCreate('create-users');
        $deleteUsersPermission = Permission::findOrCreate('delete-users');
        $updateUsersPermission = Permission::findOrCreate('update-users');

        $managingUsersRole->givePermissionTo($readUsersPermission);
        $managingUsersRole->givePermissionTo($createUsersPermission);
        $managingUsersRole->givePermissionTo($deleteUsersPermission);
        $managingUsersRole->givePermissionTo($updateUsersPermission);

        $superAdminRole = Role::findByName('super-admin');
        $superAdminRole->givePermissionTo($readUsersPermission);
        $superAdminRole->givePermissionTo($createUsersPermission);
        $superAdminRole->givePermissionTo($deleteUsersPermission);
        $superAdminRole->givePermissionTo($updateUsersPermission);

    }
}
