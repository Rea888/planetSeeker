<?php

namespace App\Data\Meteo\Surface_Pressure;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class SurfacePressureData extends AbstractMeteoData
{
    private mixed $surfacePressureMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $surfacePressureMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->surfacePressureMeasurementData = $surfacePressureMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getSurfacePressureMeasurementData(): mixed
    {
        return $this->surfacePressureMeasurementData;
    }
}
