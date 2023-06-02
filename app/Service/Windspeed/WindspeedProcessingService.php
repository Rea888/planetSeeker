<?php

namespace App\Service\Windspeed;

use App\Data\DataIdentifier;
use App\Models\HistoricalWindspeedProcessingReportsModel;
use App\Service\AbstractProcessingService;

class WindspeedProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalWindspeedProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
