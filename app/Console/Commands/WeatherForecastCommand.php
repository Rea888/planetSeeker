<?php

namespace App\Console\Commands;

use App\Models\API\APIcalling;
use App\Service\WeatherForecastService;
use Illuminate\Console\Command;

class WeatherForecastCommand extends Command
{

    private WeatherForecastService $weatherForecastService;

    public function __construct(WeatherForecastService $weatherForecastService)
    {
        parent::__construct();
        $this->weatherForecastService = $weatherForecastService;
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
     * @return int
     */
    public function handle()
    {
        $get_data = APIcalling::callAPI('GET', 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m', false);
        $response = json_decode($get_data, true);
        $this->weatherForecastService->processApiResponse($response);
    }
}
