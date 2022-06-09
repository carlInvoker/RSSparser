<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MakeDateFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:datefile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create storage text file for saving last news date from RSS';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $firstDate = Carbon::createFromTimestamp(0)->toDateTimeString();
        Storage::disk('local')->put('dates.txt', $firstDate);
    }
}
