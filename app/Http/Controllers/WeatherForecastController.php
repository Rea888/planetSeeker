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

    private function getLatitudeAndLongitude(string $cityName): array
    {
        $get_data = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address=' . $cityName . '&key='.config('services.google.key'));
        $response = json_decode($get_data, true);
        $longitudeLatitudeArray= $this->weatherForecastService->processMapApiResponse($response);
        return $longitudeLatitudeArray;
    }

    public function getWeather(string $cityName)
    {

        $latitudeAndLongitude = $this->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude['0'];
        $longitude = $latitudeAndLongitude['1'];

        $get_data = Http::get('https://api.open-meteo.com/v1/forecast?latitude=' . $latitude . '&longitude=' . $longitude . '&hourly=temperature_2m');
        var_dump(json_decode($get_data, true));

//        $this->weatherForecastService->processWeatherApiResponse($response);

    }


}
