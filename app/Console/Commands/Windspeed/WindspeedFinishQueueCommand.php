<?php

namespace App\Console\Commands\Windspeed;

use App\Jobs\ProcessWindspeedJob;
use App\Models\HistoricalWindspeedProcessingReportsModel;
use Illuminate\Console\Command;

class WindspeedFinishQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'windspeed:finishQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its windspeed in historical_windspeed database ';


    public function handle()
    {
        $unprocessedWindspeedModels = HistoricalWindspeedProcessingReportsModel::where('processing_finished_at', null)->get();
        foreach ($unprocessedWindspeedModels as $unprocessedWindspeedModel){
            $job = new ProcessWindspeedJob($unprocessedWindspeedModel);
            dispatch($job);
        }
    }
}
