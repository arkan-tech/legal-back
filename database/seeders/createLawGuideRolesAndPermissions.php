<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class createLawGuideRolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $managingLawGuideRole = Role::findOrCreate('manage-law-guide');

        $readLawGuidePermission = Permission::findOrCreate('read-law-guide');
        $createLawGuidePermission = Permission::findOrCreate('create-law-guide');
        $deleteLawGuidePermission = Permission::findOrCreate('delete-law-guide');
        $updateLawGuidePermission = Permission::findOrCreate('update-law-guide');

        $managingLawGuideRole->givePermissionTo($readLawGuidePermission);
        $managingLawGuideRole->givePermissionTo($createLawGuidePermission);
        $managingLawGuideRole->givePermissionTo($deleteLawGuidePermission);
        $managingLawGuideRole->givePermissionTo($updateLawGuidePermission);

        $superAdminRole = Role::findByName('super-admin');
        $superAdminRole->givePermissionTo($readLawGuidePermission);
        $superAdminRole->givePermissionTo($createLawGuidePermission);
        $superAdminRole->givePermissionTo($deleteLawGuidePermission);
        $superAdminRole->givePermissionTo($updateLawGuidePermission);
    }
}
