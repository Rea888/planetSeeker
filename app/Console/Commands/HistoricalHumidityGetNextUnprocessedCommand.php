<?php

namespace App\Console\Commands;

use App\Service\HistoricalHumidityProcessingService;
use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Console\Command;

class HistoricalHumidityGetNextUnprocessedCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unprocessedHumidity:track {historicalWeatherHumidityModel}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the next unprocessed single entity from historical_humidity_processing_reports_models table';
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;
    private HistoricalHumidityProcessingService $historicalHumidityProcessingService;

    public function __construct(HistoricalWeatherHumidityService $historicalWeatherHumidityService, HistoricalHumidityProcessingService $historicalHumidityProcessingService)
    {
        parent::__construct();
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
        $this->historicalHumidityProcessingService = $historicalHumidityProcessingService;
    }

    public function handle()
    {
        //create a service method somewhere with the name getNextUnprocessedHumidity (to get the first record from historical_humidity_processing_reports_models where processing began_at == null)
        //then pass that model to the $this->historicalWeatherHumidityService->process
        $historicalWeatherHumidityModel = $this->historicalHumidityProcessingService->getNextUnprocessedHumidityModel();
        $this->historicalWeatherHumidityService->process($historicalWeatherHumidityModel);
    }
}
