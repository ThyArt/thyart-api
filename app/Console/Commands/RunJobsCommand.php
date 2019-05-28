<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\QueryStatisticsJob;
use Illuminate\Queue\Queue;

class RunJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the jobs required to gather user statistics';

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
        $job = new QueryStatisticsJob();
        $job::dispatchNow();
    }
}
