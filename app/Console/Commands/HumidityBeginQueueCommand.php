<?php

namespace App\Console\Commands;

use App\Jobs\ProcessHumidity;
use App\Service\HistoricalHumidityProcessingService;
use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Console\Command;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class HumidityBeginQueueCommand extends Command
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
    protected $signature = 'humidity:beginQue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find models with null value at processing_began_at and give them to a job to save its humidity in historical_weather_humidity database ';


    public function handle()
    {
        $unprocessedHumidityModels = $this->historicalHumidityProcessingService->getUnprocessedHumidityModelsBeganAt();
        foreach ($unprocessedHumidityModels as $unprocessedHumidityModel) {
            $job = new ProcessHumidity($unprocessedHumidityModel);
            dispatch($job);
        }
    }
}
