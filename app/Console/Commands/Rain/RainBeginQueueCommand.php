<?php

namespace App\Console\Commands\Rain;

use App\Jobs\ProcessRainJob;
use App\Models\HistoricalRainProcessingReportsModel;
use Illuminate\Console\Command;


class RainBeginQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rain:beginQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its rain value in historical_rain database ';


    public function handle()
    {
        $unprocessedRainModels = HistoricalRainProcessingReportsModel::where('processing_began_at', null)->get();
        foreach ($unprocessedRainModels as $unprocessedRainModel) {
            $job = new ProcessRainJob($unprocessedRainModel);
            dispatch($job);
        }
    }
}
