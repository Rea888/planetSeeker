<?php

namespace App\Service;

use App\Models\WeatherForecastModel;

class WeatherForecastService
{
    public function processApiResponse(array $apiResponse)
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
}
