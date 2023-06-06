<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Snowfall\SnowfallData;
use Illuminate\Http\Client\Response;

class SnowfallDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): SnowfallData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new SnowfallData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_SNOWFALL]
        );
    }
}
