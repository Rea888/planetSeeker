<?php

namespace App\Data\Meteo\Windspeed;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class WindspeedData extends AbstractMeteoData
{
    private mixed $windspeedMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $windspeedMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->windspeedMeasurementData = $windspeedMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getWindspeedMeasurementData(): mixed
    {
        return $this->windspeedMeasurementData;
    }
}
