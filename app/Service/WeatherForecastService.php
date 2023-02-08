<?php

namespace App\Service;

use App\Models\WeatherForecastModel;

class WeatherForecastService
{
    public function processWeatherApiResponse(array $apiResponse) :void
    {
        $longitude = $apiResponse['longitude'];
        $latitude = $apiResponse['latitude'];

        foreach ($apiResponse['hourly']['time'] as $key => $dateTimeOfMeasurement) {
            $temperature = $apiResponse['hourly']['temperature_2m'][$key];

            WeatherForecastModel::updateOrCreate(
                [
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'date_time_of_measurement' => $dateTimeOfMeasurement,

                ],
                [
                    'temperature' => $temperature,
                ]
            );
        }
    }


    public function processMapApiResponse(array $apiResponse) :array
    {
        $latitude= $apiResponse['results'][0]['geometry']['location']['lat'];
        $longitude = $apiResponse['results'][0]['geometry']['location']['lng'];
        return array($latitude,$longitude);
    }
}
