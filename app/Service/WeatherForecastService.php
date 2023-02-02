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

            $weatherForecastModel = new WeatherForecastModel();
            $weatherForecastModel->longitude = $longitude;
            $weatherForecastModel->latitude = $latitude;
            $weatherForecastModel->date_time_of_measurement = $dateTimeOfMeasurement;
            $weatherForecastModel->temperature = $temperature;
            var_dump($weatherForecastModel);
//            $WeatherForecastModel->save();

        }


    }
}
