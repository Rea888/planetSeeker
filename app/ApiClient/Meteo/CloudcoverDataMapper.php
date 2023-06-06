<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Cloudcover\CloudcoverData;
use Illuminate\Http\Client\Response;

class CloudcoverDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): CloudcoverData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new CloudcoverData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_CLOUDCOVER]
        );
    }
}
