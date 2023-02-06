<?php

namespace App\Http\Controllers;

use App\Service\WeatherForecastService;
use Illuminate\Support\Facades\Http;
class WeatherForecastController extends Controller
{

    private WeatherForecastService $weatherForecastService;

    public function __construct(WeatherForecastService $weatherForecastService)
    {

        $this->weatherForecastService = $weatherForecastService;
    }

    public function getWeather()
    {

        $get_data = Http::get('https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m');
        $response = json_decode($get_data, true);
        $this->weatherForecastService->processApiResponse($response);

    }


}
