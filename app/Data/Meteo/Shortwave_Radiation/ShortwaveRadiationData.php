<?php

namespace App\Data\Meteo\Shortwave_Radiation;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class ShortwaveRadiationData extends AbstractMeteoData
{
    private mixed $shortwaveRadiationMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $shortwaveRadiationMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->shortwaveRadiationMeasurementData = $shortwaveRadiationMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getShortwaveRadiationMeasurementData(): mixed
    {
        return $this->shortwaveRadiationMeasurementData;
    }
}
