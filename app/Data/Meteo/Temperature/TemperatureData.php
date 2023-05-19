<?php

namespace App\Data\Meteo\Temperature;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class TemperatureData extends AbstractMeteoData
{
    private mixed $temperatureMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $temperatureMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->temperatureMeasurementData = $temperatureMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getTemperatureMeasurementData(): mixed
    {
        return $this->temperatureMeasurementData;
    }
}
