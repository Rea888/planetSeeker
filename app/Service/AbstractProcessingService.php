<?php

namespace App\Service;

use App\Contracts\InitializableProcessingServiceInterface;
use DateTime;

abstract class AbstractProcessingService implements InitializableProcessingServiceInterface
{
    public function getModelBasicData(DateTime $startDate, string $city): array
    {
        return [
            'city' => $city,
            'year' => $startDate->format('Y'),
            'month' => $startDate->format('m'),
        ];
    }
}
