<?php

namespace App\Http\Controllers;

use App\Models\API\APIcalling;
use App\Service\WeatherForecastService;
use Illuminate\Http\Request;

class WeatherForecastController extends Controller
{

    private WeatherForecastService $weatherForecastService;

    public function __construct(WeatherForecastService $weatherForecastService)
    {

        $this->weatherForecastService = $weatherForecastService;
    }
    public function getWeather()
    {

        $get_data = APIcalling::callAPI('GET', 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m', false);
        $response = json_decode($get_data, true);
        $this->weatherForecastService->processApiResponse($response);

    }
}
