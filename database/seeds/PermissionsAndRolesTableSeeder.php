<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsAndRolesTableSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [];
        $permissions[] = Permission::create(['name' => 'store member']);
        $permissions[] = Permission::create(['name' => 'update role']);
        $permissions[] = Permission::create(['name' => 'store artist']);
        $permissions[] = Permission::create(['name' => 'get artist']);
        $permissions[] = Permission::create(['name' => 'update artist']);
        $permissions[] = Permission::create(['name' => 'destroy artist']);
        $permissions[] = Permission::create(['name' => 'store customer']);
        $permissions[] = Permission::create(['name' => 'get customer']);
        $permissions[] = Permission::create(['name' => 'update customer']);
        $permissions[] = Permission::create(['name' => 'destroy customer']);
        $permissions[] = Permission::create(['name' => 'store artwork']);
        $permissions[] = Permission::create(['name' => 'get artwork']);
        $permissions[] = Permission::create(['name' => 'update artwork']);
        $permissions[] = Permission::create(['name' => 'destroy artwork']);
        $permissions[] = Permission::create(['name' => 'store artwork image']);
        $permissions[] = Permission::create(['name' => 'destroy artwork image']);


        $admin = Role::create(['name' => 'admin']);
        $admin->syncPermissions($permissions);


        $gallerist = Role::create(['name' => 'gallerist']);
        $gallerist->syncPermissions($permissions);
        $gallerist->revokePermissionTo('store member');
        $gallerist->revokePermissionTo('update role');

        $member = Role::create(['name' => 'member']);
        $member->syncPermissions($permissions);
        $member->revokePermissionTo('store member');
        $member->revokePermissionTo('update role');
        $member->revokePermissionTo('destroy artist');
        $member->revokePermissionTo('destroy customer');
        $member->revokePermissionTo('destroy artwork');
        $member->revokePermissionTo('destroy artwork image');
    }
}
