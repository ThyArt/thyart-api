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

        $permissions[] = Permission::findOrCreate('store member');
        $permissions[] = Permission::findOrCreate('update role');
        $permissions[] = Permission::findOrCreate('store artist');
        $permissions[] = Permission::findOrCreate('get artist');
        $permissions[] = Permission::findOrCreate('update artist');
        $permissions[] = Permission::findOrCreate('destroy artist');
        $permissions[] = Permission::findOrCreate('store customer');
        $permissions[] = Permission::findOrCreate('get customer');
        $permissions[] = Permission::findOrCreate('update customer');
        $permissions[] = Permission::findOrCreate('destroy customer');
        $permissions[] = Permission::findOrCreate('store exhibition');
        $permissions[] = Permission::findOrCreate('get exhibition');
        $permissions[] = Permission::findOrCreate('update exhibition');
        $permissions[] = Permission::findOrCreate('destroy exhibition');
        $permissions[] = Permission::findOrCreate('store artwork');
        $permissions[] = Permission::findOrCreate('get artwork');
        $permissions[] = Permission::findOrCreate('update artwork');
        $permissions[] = Permission::findOrCreate('destroy artwork');
        $permissions[] = Permission::findOrCreate('store artwork image');
        $permissions[] = Permission::findOrCreate('destroy artwork image');

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions($permissions);

        $gallerist = Role::findOrCreate('gallerist');
        $gallerist->syncPermissions($permissions);
        $gallerist->revokePermissionTo('store member');
        $gallerist->revokePermissionTo('update role');

        $member = Role::findOrCreate('member');
        $member->syncPermissions($permissions);
        $member->revokePermissionTo('store member');
        $member->revokePermissionTo('update role');
        $member->revokePermissionTo('destroy artist');
        $member->revokePermissionTo('destroy customer');
        $member->revokePermissionTo('destroy exhibition');
        $member->revokePermissionTo('destroy artwork');
        $member->revokePermissionTo('destroy artwork image');
    }
}
