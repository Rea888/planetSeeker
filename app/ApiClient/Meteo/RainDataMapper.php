<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Rain\RainData;
use Illuminate\Http\Client\Response;

class RainDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): RainData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new RainData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_RAIN]
        );
    }
}
