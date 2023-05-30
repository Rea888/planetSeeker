<?php

namespace App\ApiClient\Meteo;

use App\Data\CoordinatesData;

abstract class AbstractMeteoDataMapper
{
    protected function getCoordinatesData(mixed $parsedResponse): CoordinatesData
    {
        return new CoordinatesData($parsedResponse['longitude'], $parsedResponse['latitude']);
    }
}
