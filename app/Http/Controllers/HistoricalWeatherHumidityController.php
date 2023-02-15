<?php

namespace App\Http\Controllers;

use App\Repository\HistoricalWeatherTenYearDatesCreator;
use App\Repository\LongitudeLatitudeRepository;
use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoricalWeatherHumidityController extends Controller
{

    private LongitudeLatitudeRepository $longitudeLatitudeRepository;
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;
    private HistoricalWeatherTenYearDatesCreator $historicalWeatherTenYearDatesCreator;

    public function __construct(LongitudeLatitudeRepository          $longitudeLatitudeRepository,
                                HistoricalWeatherHumidityService     $historicalWeatherHumidityService,
                                HistoricalWeatherTenYearDatesCreator $historicalWeatherTenYearDatesCreator)
    {

        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
        $this->historicalWeatherTenYearDatesCreator = $historicalWeatherTenYearDatesCreator;
    }

    public function getHistoricalWeatherHumidity($cityName)
    {

        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude['0'];
        $longitude = $latitudeAndLongitude['1'];


        foreach ($this->historicalWeatherTenYearDatesCreator->startDatesArray() as $key => $startDate) {
            $endDate = $this->historicalWeatherTenYearDatesCreator->endDatesArray()[$key];
            $get_data = Http::get('https://archive-api.open-meteo.com/v1/archive?latitude=' . $latitude . '&longitude=' . $longitude . '&start_date=' . $startDate[0] . '&end_date=' . $endDate[0] . '&hourly=relativehumidity_2m');
            $response = json_decode($get_data, true);
            var_dump($response);
            //$this->historicalWeatherHumidityService->processHistoricalWeatherHumidityApiResponse($response);
        }


    }
}
