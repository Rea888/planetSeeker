<?php

namespace App\Console\Commands\Windspeed;

use App\Jobs\ProcessWindspeedJob;
use App\Models\HistoricalWindspeedModelProcessingReportsModel;
use Illuminate\Console\Command;

class WindspeedBeginQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'windspeed:beginQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its windspeed in historical_windspeed database ';


    public function handle()
    {
        $unprocessedWindspeedModels = HistoricalWindspeedModelProcessingReportsModel::where('processing_began_at', null)->get();
        foreach ($unprocessedWindspeedModels as $unprocessedWindspeedModel){
            $job = new ProcessWindspeedJob($unprocessedWindspeedModel);
            dispatch($job);
        }
    }
}
