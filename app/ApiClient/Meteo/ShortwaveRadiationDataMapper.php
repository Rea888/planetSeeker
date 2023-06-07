<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Shortwave_Radiation\ShortwaveRadiationData;
use Illuminate\Http\Client\Response;

class ShortwaveRadiationDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): ShortwaveRadiationData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new ShortwaveRadiationData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_SHORTWAVE_RADIATION]
        );
    }
}
