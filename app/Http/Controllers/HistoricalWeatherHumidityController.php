<?php

namespace App\Http\Controllers;

use App\Repository\LongitudeLatitudeRepository;
use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoricalWeatherHumidityController extends Controller
{

    private LongitudeLatitudeRepository $longitudeLatitudeRepository;
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;

    public function __construct(LongitudeLatitudeRepository $longitudeLatitudeRepository, HistoricalWeatherHumidityService $historicalWeatherHumidityService)
    {

        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
    }
    public function getHistoricalWeatherHumidity($cityName)
    {

        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude['0'];
        $longitude = $latitudeAndLongitude['1'];

        $get_data = Http::get('https://archive-api.open-meteo.com/v1/archive?latitude=' . $latitude . '&longitude=' . $longitude .'&start_date=2023-01-07&end_date=2023-02-06&hourly=relativehumidity_2m');
        $response = json_decode($get_data, true);
        $this->historicalWeatherHumidityService->processHistoricalWeatherHumidityApiResponse($response);

    }
}
