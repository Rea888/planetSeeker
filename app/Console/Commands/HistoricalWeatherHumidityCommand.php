<?php

namespace App\Console\Commands;

use App\Service\ApiDataService;
use Illuminate\Console\Command;

class HistoricalWeatherHumidityCommand extends Command
{

    private ApiDataService $historicalWeatherHumidityService;

    public function __construct(ApiDataService $historicalWeatherHumidityService)
    {
        parent::__construct();
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historicalWeatherHumidity:progress {cityName} {year} {month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        $cityName = $this->argument('cityName');
        $year = $this->argument('year');
        $month = $this->argument('month');
        $this->historicalWeatherHumidityService->getParametersFromApi($cityName, $year, $month);
    }
}
