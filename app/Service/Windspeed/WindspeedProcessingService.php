<?php

namespace App\Service\Windspeed;

use App\Data\DataIdentifier;
use App\Models\HistoricalWindspeedModelProcessingReportsModel;
use App\Service\AbstractProcessingService;

class WindspeedProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalWindspeedModelProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
