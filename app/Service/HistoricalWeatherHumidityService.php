<?php

namespace App\Service;

use App\Models\HistoricalWeatherHumidityModel;

class HistoricalWeatherHumidityService
{

    public function processHistoricalWeatherHumidityApiResponse( array $apiResponse ) :void
    {
        $longitude = $apiResponse['longitude'];
        $latitude = $apiResponse['latitude'];

        foreach ($apiResponse['hourly']['time'] as $key=> $dateTimeOfMeasurement ){
            $humidity = $apiResponse['hourly']['relativehumidity_2m'][$key];

            $historicalWeatherHumidity = new HistoricalWeatherHumidityModel();
            $historicalWeatherHumidity['longitude'] = $longitude;
            $historicalWeatherHumidity['latitude'] = $latitude;
            $historicalWeatherHumidity['relative_humidity_2m'] = $humidity;
            $historicalWeatherHumidity['date_time_of_measurement'] = $dateTimeOfMeasurement;
            $historicalWeatherHumidity->save();

        }
    }
}
