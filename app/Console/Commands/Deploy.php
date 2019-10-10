<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate and install passport';

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
        Artisan::call('permission:set');

        if (!Client::where('password_client', true)->exists()) {
            $client = (new Client)->forceFill([
                'user_id' => null,
                'name' => 'ThyArt Password Grant Client',
                'secret' => env('PASSPORT_CLIENT_SECRET'),
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false
            ]);

            $client->save();
        }
    }
}
