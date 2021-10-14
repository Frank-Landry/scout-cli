<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Services\GetterService;
use Illuminate\Support\Facades\Storage;
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
     * Check the entries in the results.json file for the header that you specified.
     *
     * @param GetterService $gserve
     * @param string $file_path
     * @param string $header
     * @return void
     */
    private function checkEntries(GetterService $gserve, string $file_path, string $header) : void
    {
        Storage::put('filtered_results.json', '[');
        $json = Storage::get($file_path);
        $entries = json_decode($json);
        $bar = $this->output->createProgressBar(21);
        $bar->start();
        $i = 0;
        foreach($entries as $key => $value)
        {
            $i++;
            $response_headers = $gserve->getHeaders($value->policy_url);
            $match = $gserve->verifyHeaderExists($header, $response_headers);
            if($match)
            {
                Storage::append('filtered_results.json', json_encode($value, JSON_PRETTY_PRINT));
                Storage::append('filtered_results.json', ',');
            }
            $bar->advance();
            if($i >20)
            {
                break;
            }
        }
        $bar->finish();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(GetterService $gserve) : void
    {
        $this->info('Checking for list file.');
        if(!file_exists('storage/results.json'))
        {
            $this->error('A results file in json format must exist first. Did you forget to run fetch:list first?');
            exit(0);
        }
        $this->comment('File exists');
        $header = $this->ask('What header are you checking for?', 'Content-Type');
        $this->info('checking');
        $this->checkEntries($gserve, 'results.json', $header);
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
