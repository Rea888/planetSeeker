<?php

namespace App\Service\Snowfall;

use App\Data\DataIdentifier;
use App\Models\HistoricalSnowfallProcessingReportsModel;
use App\Service\AbstractProcessingService;

class SnowfallProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalSnowfallProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity()));
    }
}
