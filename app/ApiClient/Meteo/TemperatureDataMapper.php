<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Temperature\TemperatureData;
use Illuminate\Http\Client\Response;

class TemperatureDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): TemperatureData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new TemperatureData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_TEMPERATURE]
        );
    }
}
