<?php

namespace App\Http\Controllers;

use App\ApiClient\Google\GoogleApiClient;
use App\Service\WeatherForecastService;
use Illuminate\Support\Facades\Http;

class WeatherForecastController extends Controller
{

    private WeatherForecastService $weatherForecastService;
    private GoogleApiClient $googleApiClient;

    public function __construct(WeatherForecastService $weatherForecastService, GoogleApiClient $googleApiClient)
    {

        $this->weatherForecastService = $weatherForecastService;
        $this->googleApiClient = $googleApiClient;
    }



    public function getWeatherForecastWeather(string $cityName)
    {

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($cityName);
        $latitude = $coordinatesData->getLatitude();
        $longitude = $coordinatesData->getLongitude();

        $get_data = Http::get('https://api.open-meteo.com/v1/forecast?latitude=' . $latitude . '&longitude=' . $longitude . '&hourly=temperature_2m');
        $response = json_decode($get_data, true);
        $this->weatherForecastService->processWeatherApiResponse($response);

    }


}
