<?php

namespace App\Console\Commands\Humidity;

use App\Jobs\ProcessHumidityJob;
use App\Models\HistoricalHumidityProcessingReportsModel;
use Illuminate\Console\Command;

class HumidityFinishQueueCommand extends Command
{

    private HistoricalHumidityProcessingReportsModel $historicalHumidityProcessingReportsModel;

    public function __construct(HistoricalHumidityProcessingReportsModel $historicalTemperatureProcessingReportsModel)
    {
        parent::__construct();
        $this->historicalHumidityProcessingReportsModel = $historicalTemperatureProcessingReportsModel;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidity:finishQue {parameter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its humidity in historical_humidity database ';


    public function handle()
    {
        $parameter = $this->argument('parameter');
        $unprocessedHumidityModels = $this->historicalHumidityProcessingReportsModel->getUnprocessedModelsWhereFinishedAtIsNull();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessHumidityJob($unprocessedHumidityModel, $parameter);
            dispatch($job);
        }
    }
}

