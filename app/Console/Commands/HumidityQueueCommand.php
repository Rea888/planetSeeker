<?php

namespace App\Console\Commands;

use App\Jobs\ProcessHumidity;
use App\Service\HistoricalHumidityProcessingService;
use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Console\Command;

class HumidityQueueCommand extends Command
{


    private HistoricalHumidityProcessingService $historicalHumidityProcessingService;

    public function __construct(HistoricalHumidityProcessingService $historicalHumidityProcessingService)
    {
        parent::__construct();

        $this->historicalHumidityProcessingService = $historicalHumidityProcessingService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidity:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null dates and give them to a job to save its humidity in historical_weather_humidity database ';


    public function handle()
    {
        $unprocessedHumidityModels = $this->historicalHumidityProcessingService->getUnprocessedHumidityModelsBeganAt();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessHumidity($unprocessedHumidityModel);
            dispatch($job);
            $this->info(sprintf("ProcessHistoricalHumidity job (id: %s) dispatched to the queue.", $unprocessedHumidityModel->id));
        }

        $unprocessedHumidityModels = $this->historicalHumidityProcessingService->getUnprocessedHumidityModelsFinishedAt();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessHumidity($unprocessedHumidityModel);
            dispatch($job);
            $this->info(sprintf("ProcessHistoricalHumidity job (id: %s) dispatched to the queue.", $unprocessedHumidityModel->id));
        }
    }
}
