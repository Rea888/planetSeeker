<?php

namespace App\Console\Commands;

use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Console\Command;

class HistoricalWeatherHumidityCommand extends Command
{

    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;

    public function __construct(HistoricalWeatherHumidityService $historicalWeatherHumidityService)
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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cityName = $this->argument('cityName');
        $year = $this->argument('year');
        $month = $this->argument('month');
        $this->historicalWeatherHumidityService->saveHistoricalWeatherHumidity($cityName, $year, $month);
    }
}
