<?php

namespace App\Console\Commands;

use App\Models\API\APIcalling;
use App\Service\WeatherForecastService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
     * @return void
     */
    public function handle(): void
    {
        $get_data = Http::get('https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m');
        $response = json_decode($get_data, true);
        $this->weatherForecastService->processApiResponse($response);
    }
}
