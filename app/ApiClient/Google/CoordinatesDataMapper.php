<?php

namespace App\ApiClient\Google;

use App\Data\CoordinatesData;

class CoordinatesDataMapper
{
    public function map(string $jsonApiResponse): CoordinatesData
    {
        $parsedResponse = json_decode($jsonApiResponse, true);

        $latitude = (float)$parsedResponse['results'][0]['geometry']['location']['lat'];
        $longitude = (float)$parsedResponse['results'][0]['geometry']['location']['lng'];

        return new CoordinatesData($longitude, $latitude);
    }
}
