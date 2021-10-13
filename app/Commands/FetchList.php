<?php

namespace App\Commands;

use App\Services\BountyListService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FetchList extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'fetch:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Fetch the bounty list from disclose.io project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(BountyListService $BL_Service)
    {
        $target = $this->ask('What is the target url?', 'https://raw.githubusercontent.com/disclose/diodb/master/program-list.json');
        $bounty_list = $BL_Service->fetchBountyList($target);
        $this->info('Bounty List Retrieved');
        $save_file = $this->ask('Where do you want this output saved to?', 'results.json');
        Storage::put($save_file, json_encode($bounty_list, JSON_PRETTY_PRINT));
        $this->info('Bounty List Saved for future use');
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
