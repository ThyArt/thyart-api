<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UnsetPermissionAndRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:unset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unset the permissions and the role found in app/Console/Commands/UnsetPermissionAndRoleCommand.php';

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
        Permission::findByName('store member')->delete();
        Permission::findByName('delete member')->delete();
        Permission::findByName('update role')->delete();
        Permission::findByName('store artist')->delete();
        Permission::findByName('get artist')->delete();
        Permission::findByName('update artist')->delete();
        Permission::findByName('destroy artist')->delete();
        Permission::findByName('store customer')->delete();
        Permission::findByName('get customer')->delete();
        Permission::findByName('update customer')->delete();
        Permission::findByName('destroy customer')->delete();
        Permission::findByName('store exhibition')->delete();
        Permission::findByName('get exhibition')->delete();
        Permission::findByName('update exhibition')->delete();
        Permission::findByName('destroy exhibition')->delete();
        Permission::findByName('store newsletter')->delete();
        Permission::findByName('get newsletter')->delete();
        Permission::findByName('update newsletter')->delete();
        Permission::findByName('destroy newsletter')->delete();
        Permission::findByName('send newsletter')->delete();
        Permission::findByName('store artwork')->delete();
        Permission::findByName('get artwork')->delete();
        Permission::findByName('update artwork')->delete();
        Permission::findByName('destroy artwork')->delete();
        Permission::findByName('store artwork image')->delete();
        Permission::findByName('destroy artwork image')->delete();

        Role::findByName('admin')->delete();
        Role::findByName('gallerist')->delete();
        Role::findByName('member')->delete();
        
        $this->line('<fg=white;bg=green>Permissions successfully unset');
    }
}
