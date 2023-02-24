<?php

namespace App\Console\Commands;

use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Console\Command;

class HistoricalHumidityTimeProcessing extends Command
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
    protected $description = 'Command description';
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;

    public function __construct(HistoricalWeatherHumidityService $historicalWeatherHumidityService)
    {
        parent::__construct();
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
    }

    public function handle()
    {
        $cityName = $this->argument('cityName');
        $year = $this->argument('year');
        $month = $this->argument('month');
        $this->historicalWeatherHumidityService->process($cityName, $year, $month);
    }
}
