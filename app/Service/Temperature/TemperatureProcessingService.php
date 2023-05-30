<?php

namespace App\Service\Temperature;

use App\Data\DataIdentifier;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use App\Service\AbstractProcessingService;

class TemperatureProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalTemperatureProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
