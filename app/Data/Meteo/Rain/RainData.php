<?php

namespace App\Data\Meteo\Rain;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class RainData extends AbstractMeteoData
{
    private mixed $rainMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $rainMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->rainMeasurementData = $rainMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getRainMeasurementData(): mixed
    {
        return $this->rainMeasurementData;
    }
}
