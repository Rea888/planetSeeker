<?php

namespace App\Service;

use App\Repository\LongitudeLatitudeRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiWeatherClient
{

    protected $base_url;
    private $longitudeLatitudeRepository;

    public function __construct($base_url, LongitudeLatitudeRepository $longitudeLatitudeRepository)
    {
        $this->base_url = $base_url;
        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;

    }


    public function getParametersFromWeatherApi($cityName, $year, $month, $parameter)
    {
        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude->getLatitude();
        $longitude = $latitudeAndLongitude->getLongitude();

        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate));
        $apiResponse = Http::get(sprintf("{$this->base_url}?latitude=%s&longitude=%s&start_date=%s&end_date=%s&hourly=%s", $latitude, $longitude, $startDate, $endDate, $parameter));

        $parsedResponse = json_decode($apiResponse, true);

        if ($apiResponse->successful()) {
            return new WeatherApiResponseWrapper($parsedResponse);
        } else {
            return 'Something is wrong with the WeatherApi';
        }
    }
}

