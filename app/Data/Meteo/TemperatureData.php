<?php

namespace App\Data\Meteo;

use App\Data\CoordinatesData;

class TemperatureData extends AbstractMeteoData
{

    private mixed $temperatureMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, string $dateTimeOfMeasurement, mixed $temperatureMeasurementData)
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
