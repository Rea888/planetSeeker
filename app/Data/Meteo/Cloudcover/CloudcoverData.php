<?php

namespace App\Data\Meteo\Cloudcover;

use App\Data\CoordinatesData;
use App\Data\Meteo\AbstractMeteoData;

class CloudcoverData extends AbstractMeteoData
{
    private mixed $cloudcoverMeasurementData;

    public function __construct(CoordinatesData $coordinatesData, array $dateTimeOfMeasurement, mixed $cloudcoverMeasurementData)
    {
        parent::__construct($coordinatesData, $dateTimeOfMeasurement);
        $this->cloudcoverMeasurementData = $cloudcoverMeasurementData;
    }

    /**
     * @return mixed
     */
    public function getCloudcoverMeasurementData(): mixed
    {
        return $this->cloudcoverMeasurementData;
    }

}
