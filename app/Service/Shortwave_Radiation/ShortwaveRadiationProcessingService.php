<?php

namespace App\Service\Shortwave_Radiation;

use App\Data\DataIdentifier;
use App\Models\HistoricalShortwaveRadiationProcessingReportsModel;
use App\Service\AbstractProcessingService;

class ShortwaveRadiationProcessingService extends AbstractProcessingService
{
    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalShortwaveRadiationProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity())
        );
    }
}
