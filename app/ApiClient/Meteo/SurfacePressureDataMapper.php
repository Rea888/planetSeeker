<?php

namespace App\ApiClient\Meteo;

use App\Data\Meteo\Surface_Pressure\SurfacePressureData;
use Illuminate\Http\Client\Response;

class SurfacePressureDataMapper extends AbstractMeteoDataMapper
{
    public function map(Response $response): SurfacePressureData
    {
        $parsedResponse = $response->json();

        $coordinatesData = $this->getCoordinatesData($parsedResponse);

        return new SurfacePressureData(
            $coordinatesData,
            $parsedResponse['hourly']['time'],
            $parsedResponse['hourly'][MeteoApiClient::HOURLY_PARAM_VALUE_SURFACE_PRESSURE]
        );
    }
}
