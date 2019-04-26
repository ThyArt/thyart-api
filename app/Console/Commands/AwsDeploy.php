<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;

class AwsDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to run next to an elastic beanstalk deployment';

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
        Artisan::call('migrate', ['--force' => true]);

        if (!Client::where('password_client', true)->exists()) {
            $client = (new Client)->forceFill([
                'user_id' => null,
                'name' => 'ThyArt Password Grant Client',
                'secret' => $_SERVER['PASSPORT_CLIENT_PASSWORD'],
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false
            ]);

            $client->save();
        }
    }
}
