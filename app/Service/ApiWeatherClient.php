<?php

namespace App\Service;

use App\ApiClient\Google\GoogleApiClient;

class ApiWeatherClient
{
    private GoogleApiClient $googleApiClient;
    protected string $base_url;

    public function __construct(GoogleApiClient $googleApiClient, string $base_url)
    {
        $this->googleApiClient = $googleApiClient;
        $this->base_url = $base_url;
    }

    public function getParametersFromWeatherApi($cityName, $year, $month, $parameter)
    {
        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($cityName);
        $latitude = $coordinatesData->getLatitude();
        $longitude = $coordinatesData->getLongitude();

        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate));
    }
}
