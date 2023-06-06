<?php

namespace App\Service\Rain;

use App\Data\DataIdentifier;
use App\Models\HistoricalRainProcessingReportsModel;
use App\Service\AbstractProcessingService;

class RainProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalRainProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity()));
    }
}
