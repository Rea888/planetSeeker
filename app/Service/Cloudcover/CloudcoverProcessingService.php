<?php

namespace App\Service\Cloudcover;

use App\Data\DataIdentifier;
use App\Models\HistoricalCloudcoverProcessingReportsModel;
use App\Service\AbstractProcessingService;

class CloudcoverProcessingService extends AbstractProcessingService
{

    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalCloudcoverProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
