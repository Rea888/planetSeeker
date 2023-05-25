<?php

namespace App\Console\Commands\Temperature;

use App\Jobs\ProcessTemperatureJob;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use Illuminate\Console\Command;

class TemperatureBeginQueueCommand extends Command
{
    private HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel;

    public function __construct(HistoricalTemperatureProcessingReportsModel $historicalTemperatureProcessingReportsModel)
    {
        parent::__construct();
        $this->historicalTemperatureProcessingReportsModel = $historicalTemperatureProcessingReportsModel;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperature:beginQue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its temperature in historical_temperature database ';


    public function handle()
    {
        $unprocessedHumidityModels = $this->historicalTemperatureProcessingReportsModel->getUnprocessedModelsWhereBeganAtIsNull();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessTemperatureJob($unprocessedHumidityModel);
            dispatch($job);
        }
    }
}

