<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetPermissionAndRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the permissions and the role found in app/Console/Commands/SetPermissionAndRoleCommand.php';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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

        $this->line('<fg=white;bg=green>Permissions successfully set');
    }
}
