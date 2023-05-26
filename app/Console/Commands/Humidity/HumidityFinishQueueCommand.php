<?php

namespace App\Console\Commands\Humidity;

use App\Jobs\ProcessHumidityJob;
use App\Models\HistoricalHumidityProcessingReportsModel;
use Illuminate\Console\Command;

class HumidityFinishQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidity:finishQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its humidity in historical_humidity database ';


    public function handle()
    {

        $unprocessedHumidityModels = HistoricalHumidityProcessingReportsModel::where('processing_finished_at', null)->get();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessHumidityJob($unprocessedHumidityModel);
            dispatch($job);
        }
    }
}

