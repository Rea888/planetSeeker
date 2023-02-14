<?php

namespace App\Http\Controllers;

use App\Repository\LongitudeLatitudeRepository;
use App\Service\WeatherForecastService;
use Illuminate\Support\Facades\Http;

class WeatherForecastController extends Controller
{

    private WeatherForecastService $weatherForecastService;
    private LongitudeLatitudeRepository $longitudeLatitudeRepository;

    public function __construct(WeatherForecastService $weatherForecastService, LongitudeLatitudeRepository $longitudeLatitudeRepository)
    {

        $this->weatherForecastService = $weatherForecastService;
        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
    }



    public function getWeatherForecastWeather(string $cityName)
    {

        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude['0'];
        $longitude = $latitudeAndLongitude['1'];

        $get_data = Http::get('https://api.open-meteo.com/v1/forecast?latitude=' . $latitude . '&longitude=' . $longitude . '&hourly=temperature_2m');
        $response = json_decode($get_data, true);
        $this->weatherForecastService->processWeatherApiResponse($response);

    }


}
