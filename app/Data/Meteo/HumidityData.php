<?php

namespace App\Data\Meteo;

use App\Data\CoordinatesData;

class HumidityData extends AbstractMeteoData
{

    private mixed $humidityMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, string $dateTimeOfMeasurement, mixed $humidityMeasurementData)
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
