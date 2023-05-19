<?php

namespace App\Service\Humidity;


use App\Data\DataIdentifier;
use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Service\AbstractProcessingService;

class HumidityProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalHumidityProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
