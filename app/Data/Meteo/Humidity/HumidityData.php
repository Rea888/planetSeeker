<?php

namespace App\Data\Meteo\Humidity;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class HumidityData extends AbstractMeteoData
{
    private mixed $humidityMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $humidityMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->humidityMeasurementData = $humidityMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getHumidityMeasurementData(): mixed
    {
        return $this->humidityMeasurementData;
    }
}
