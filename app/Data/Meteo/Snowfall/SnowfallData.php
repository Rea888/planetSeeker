<?php

namespace App\Data\Meteo\Snowfall;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class SnowfallData extends AbstractMeteoData
{
    private mixed $snowfallMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $snowfallMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->snowfallMeasurementData = $snowfallMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getSnowfallMeasurementData(): mixed
    {
        return $this->snowfallMeasurementData;
    }
}
