<?php

namespace App\Service;

use App\Models\HistoricalWeatherHumidityModel;
use App\Repository\LongitudeLatitudeRepository;
use Illuminate\Support\Facades\Http;

class HistoricalWeatherHumidityService
{
    private LongitudeLatitudeRepository $longitudeLatitudeRepository;

    public function __construct(LongitudeLatitudeRepository $longitudeLatitudeRepository)
    {

        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
    }

    public function processHistoricalWeatherHumidityApiResponse(array $apiResponse): void
    {
        $longitude = $apiResponse['longitude'];
        $latitude = $apiResponse['latitude'];

        foreach ($apiResponse['hourly']['time'] as $key => $dateTimeOfMeasurement) {
            $humidity = $apiResponse['hourly']['relativehumidity_2m'][$key];

            $historicalWeatherHumidity = new HistoricalWeatherHumidityModel();
            $historicalWeatherHumidity->longitude = $longitude;
            $historicalWeatherHumidity->latitude = $latitude;
            $historicalWeatherHumidity->relative_humidity_2m = $humidity;
            $historicalWeatherHumidity->date_time_of_measurement = $dateTimeOfMeasurement;
            $historicalWeatherHumidity->save();

        }
    }

    public function saveHistoricalWeatherHumidity($cityName, $year, $month)
    {

        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude->getLatitude();
        $longitude = $latitudeAndLongitude->getLongitude();


        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate));

        $apiResponse = Http::get('https://archive-api.open-meteo.com/v1/archive?latitude=' . $latitude . '&longitude=' . $longitude . '&start_date=' . $startDate . '&end_date=' . $endDate . '&hourly=relativehumidity_2m');
        $parsedResponse = json_decode($apiResponse, true);
        $this->processHistoricalWeatherHumidityApiResponse($parsedResponse);


    }
}
