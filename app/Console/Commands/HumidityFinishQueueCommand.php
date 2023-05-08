<?php

namespace App\Console\Commands;

use App\Jobs\ProcessHumidity;
use App\Service\ModelProcessingService;
use Illuminate\Console\Command;

class HumidityFinishQueueCommand extends Command
{

    private ModelProcessingService $historicalHumidityProcessingService;

    public function __construct(ModelProcessingService $historicalHumidityProcessingService)
    {
        parent::__construct();

        $this->historicalHumidityProcessingService = $historicalHumidityProcessingService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidity:finishQue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_finished_at and give them to a job to save its humidity in historical_weather_humidity database ';


    public function handle()
    {
        $unprocessedHumidityModels = $this->historicalHumidityProcessingService->getUnprocessedModelsFinishedAt();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessHumidity($unprocessedHumidityModel);
            dispatch($job);
        }
    }
}
