<?php

namespace App\Service\Surface_Pressure;

use App\Data\DataIdentifier;
use App\Models\HistoricalSurfacePressureProcessingReportsModel;
use App\Service\AbstractProcessingService;

class SurfacePressureProcessingService extends AbstractProcessingService
{
    public function initialize(DataIdentifier $dataIdentifier)
    {
        HistoricalSurfacePressureProcessingReportsModel::firstOrCreate(
            $this->getModelBasicData($dataIdentifier->getDateTime(), $dataIdentifier->getCity()));
    }
}
