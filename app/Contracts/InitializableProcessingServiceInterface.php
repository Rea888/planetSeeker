<?php

namespace App\Contracts;


use App\Data\DataIdentifier;

interface InitializableProcessingServiceInterface
{
    public function initialize(DataIdentifier $dataIdentifier);
}
