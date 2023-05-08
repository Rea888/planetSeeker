<?php

namespace App\Console\Commands;

use App\Service\ApiDataService;
use Illuminate\Console\Command;

class ProcessingModelsTableCommand extends Command
{

    private ApiDataService $historicalWeatherHumidityService;

    public function __construct(ApiDataService $modelService)
    {
        parent::__construct();
        $this->historicalWeatherHumidityService = $modelService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historicalWeatherHumidity:progress {cityName} {year} {month} {parameter}';

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
        $parameter = $this->argument('parameter');
        $this->historicalWeatherHumidityService->getParametersFromApi($cityName, $year, $month, $parameter);
    }
}
