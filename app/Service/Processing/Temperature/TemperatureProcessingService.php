<?php

namespace App\Service\Processing\Temperature;

use App\Data\DataIdentifier;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use App\Service\Processing\AbstractProcessingService;

class TemperatureProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalTemperatureProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
