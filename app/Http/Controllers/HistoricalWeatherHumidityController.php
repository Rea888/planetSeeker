<?php

namespace App\Http\Controllers;

use App\Repository\HistoricalWeatherTenYearDatesCreator;
use App\Repository\LongitudeLatitudeRepository;
use App\Service\HistoricalWeatherHumidityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PHPUnit\Util\Exception;

class HistoricalWeatherHumidityController extends Controller
{

    private LongitudeLatitudeRepository $longitudeLatitudeRepository;
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;

    public function __construct(LongitudeLatitudeRepository      $longitudeLatitudeRepository,
                                HistoricalWeatherHumidityService $historicalWeatherHumidityService)
    {

        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
    }

    public function getHistoricalWeatherHumidity(string $cityName, $year, $month)
    {

        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude['0'];
        $longitude = $latitudeAndLongitude['1'];


        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate));

        $get_data = Http::get('https://archive-api.open-meteo.com/v1/archive?latitude=' . $latitude . '&longitude=' . $longitude . '&start_date=' . $startDate . '&end_date=' . $endDate . '&hourly=relativehumidity_2m');
        $response = json_decode($get_data, true);
        var_dump($response);
        $this->historicalWeatherHumidityService->processHistoricalWeatherHumidityApiResponse($response);


    }
}

