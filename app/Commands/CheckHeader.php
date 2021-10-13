<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Services\GetterService;

class CheckHeader extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'check:header';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Use this command to check the bounty lists for entries who have a header that matches what you provide.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(GetterService $gserve)
    {
        $header = $this->ask('What header are you checking for?', 'content-type');
        $this->info('checking');
        // todo pick out target url from results.json file
        $response_headers = $gserve->getHeaders($target_url, $header);
        $this->info('done');
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
