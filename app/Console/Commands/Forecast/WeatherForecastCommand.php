<?php

namespace App\Console\Commands\Forecast;

use App\Http\Controllers\WeatherForecastController;
use Illuminate\Console\Command;

class WeatherForecastCommand extends Command
{
    private WeatherForecastController $weatherForecastController;

    public function __construct(WeatherForecastController $weatherForecastController)
    {
        parent::__construct();
        $this->weatherForecastController = $weatherForecastController;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weatherforecast:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save weather forecast temperature to DB';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->weatherForecastController->getWeatherForecastWeather('Paris');
        $this->weatherForecastController->getWeatherForecastWeather('Moscow');
        $this->weatherForecastController->getWeatherForecastWeather('Washington');
        $this->weatherForecastController->getWeatherForecastWeather('London');
        $this->weatherForecastController->getWeatherForecastWeather('Tokyo');
    }
}
