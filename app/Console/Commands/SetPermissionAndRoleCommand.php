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

        $this->line('<fg=white;bg=green>Permissions successfully set');
    }
}
