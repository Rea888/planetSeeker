<?php

namespace App\Console\Commands;

use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Console\Command;

class HistoricalHumidityTimeProcessingCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidityTime:track {cityName} {year} {month}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the next unprocessed single entity from historical_humidity_processing_reports_models table';
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;

    public function __construct(HistoricalWeatherHumidityService $historicalWeatherHumidityService)
    {
        parent::__construct();
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
    }

    public function handle()
    {
        //create a service method somewhere with the name getNextUnprocessedHumidity (to get the first record from historical_humidity_processing_reports_models where processing began_at == null)
        //then pass that model to the $this->historicalWeatherHumidityService->process
        $cityName = $this->argument('cityName');
        $year = $this->argument('year');
        $month = $this->argument('month');
        $this->historicalWeatherHumidityService->process($cityName, $year, $month);
    }
}
