<?php

namespace App\Service;

use App\ApiClient\Google\GoogleApiClient;
use App\Repository\LongitudeLatitudeRepository;
use Illuminate\Support\Facades\Http;

class ApiWeatherClient
{

    private GoogleApiClient $googleApiClient;
    protected string $base_url;

    public function __construct(
        GoogleApiClient $googleApiClient,
        string          $base_url
    )
    {
        $this->base_url = $base_url;
        $this->googleApiClient = $googleApiClient;
    }


    public function getParametersFromWeatherApi($cityName, $year, $month, $parameter)
    {
        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($cityName);
        $latitude = $coordinatesData->getLatitude();
        $longitude = $coordinatesData->getLongitude();

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

