<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Humidity\HumidityData;
use Illuminate\Http\Client\Response;

class HumidityDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): HumidityData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new HumidityData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_HUMIDITY]
        );
    }

}
