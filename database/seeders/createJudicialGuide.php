<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class createJudicialGuide extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $managingJudicialGuideRole = Role::findOrCreate('manage-judicial-guide');

        $readJudicialGuidePermission = Permission::findOrCreate('read-judicial-guide');
        $createJudicialGuidePermission = Permission::findOrCreate('create-judicial-guide');
        $deleteJudicialGuidePermission = Permission::findOrCreate('delete-judicial-guide');
        $updateJudicialGuidePermission = Permission::findOrCreate('update-judicial-guide');

        $managingJudicialGuideRole->givePermissionTo($readJudicialGuidePermission);
        $managingJudicialGuideRole->givePermissionTo($createJudicialGuidePermission);
        $managingJudicialGuideRole->givePermissionTo($deleteJudicialGuidePermission);
        $managingJudicialGuideRole->givePermissionTo($updateJudicialGuidePermission);

        $superAdminRole = Role::findByName('super-admin');
        $superAdminRole->givePermissionTo($readJudicialGuidePermission);
        $superAdminRole->givePermissionTo($createJudicialGuidePermission);
        $superAdminRole->givePermissionTo($deleteJudicialGuidePermission);
        $superAdminRole->givePermissionTo($updateJudicialGuidePermission);
    }
}
