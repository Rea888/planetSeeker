<?php

namespace App\Service\Processing\Humidity;

use App\Data\DataIdentifier;
use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Service\Processing\AbstractProcessingService;

class HumidityProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalHumidityProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
