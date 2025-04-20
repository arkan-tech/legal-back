<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class createBooksRolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $managingBooksRole = Role::findOrCreate('manage-books');

        $readBooksPermission = Permission::findOrCreate('read-books');
        $createBooksPermission = Permission::findOrCreate('create-books');
        $deleteBooksPermission = Permission::findOrCreate('delete-books');
        $updateBooksPermission = Permission::findOrCreate('update-books');

        $managingBooksRole->givePermissionTo($readBooksPermission);
        $managingBooksRole->givePermissionTo($createBooksPermission);
        $managingBooksRole->givePermissionTo($deleteBooksPermission);
        $managingBooksRole->givePermissionTo($updateBooksPermission);

        $superAdminRole = Role::findByName('super-admin');
        $superAdminRole->givePermissionTo($readBooksPermission);
        $superAdminRole->givePermissionTo($createBooksPermission);
        $superAdminRole->givePermissionTo($deleteBooksPermission);
        $superAdminRole->givePermissionTo($updateBooksPermission);
    }
}
