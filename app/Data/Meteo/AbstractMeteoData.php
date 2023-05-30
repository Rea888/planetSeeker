<?php

namespace App\Data\Meteo;

use App\Data\CoordinatesData;

abstract class AbstractMeteoData
{
    private CoordinatesData $coordinatesData;
    private array $dateTimeOfMeasurement;

    public function __construct(
        CoordinatesData $coordinatesData,
        array         $dateTimeOfMeasurement,
    )
    {

        $this->coordinatesData = $coordinatesData;
        $this->dateTimeOfMeasurement = $dateTimeOfMeasurement;
    }

    public function getLatitude(): float
    {
        return $this->coordinatesData->getLatitude();
    }

    public function getLongitude(): float
    {
        return $this->coordinatesData->getLongitude();
    }

    public function getDateTimeOfMeasurement(): array
    {
        return $this->dateTimeOfMeasurement;
    }
}
