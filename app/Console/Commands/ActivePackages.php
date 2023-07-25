<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\frontend\CronJobController;
class ActivePackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $CronJobController;
    public function __construct(CronJobController $CronJobController)
    {
        $this->CronJobController = $CronJobController;
        parent::__construct();
    }

    protected $signature = 'activate:packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Active disabled user packages';

    /**
     * Create a new command instance.
     *
     * @return void
     */


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->CronJobController->activateDisabledPackages();
    }
}
