<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Windspeed\WindspeedData;
use Illuminate\Http\Client\Response;

class WindspeedDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): WindspeedData
    {
        $parsedResponse = $response->json();
        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new WindspeedData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_WINDSPEED]
        );
    }
}
