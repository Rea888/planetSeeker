<?php

namespace App\Service\Processing;

use App\Data\DataIdentifier;

interface InitializableProcessingServiceInterface
{
    public function initialize(DataIdentifier $dataIdentifier);
}
