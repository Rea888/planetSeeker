<?php

namespace App\Console\Commands;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->weatherForecastController->getWeather('Moscow');

    }
}
