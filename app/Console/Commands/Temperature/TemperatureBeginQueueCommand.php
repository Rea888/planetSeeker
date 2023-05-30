<?php

namespace App\Console\Commands\Temperature;

use App\Jobs\ProcessTemperatureJob;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use Illuminate\Console\Command;

class TemperatureBeginQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperature:beginQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its temperature in historical_temperature database ';


    public function handle()
    {
        $unprocessedHumidityModels = HistoricalTemperatureProcessingReportsModel::where('processing_began_at', null)->get();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessTemperatureJob($unprocessedHumidityModel);
            dispatch($job);
        }
    }
}

