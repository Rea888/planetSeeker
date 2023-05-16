<?php

namespace App\Service\Processing;

use DateTime;

abstract class AbstractProcessingService implements InitializableProcessingServiceInterface
{
    public function getModelBasicData(DateTime $startDate, string $city): array
    {
        return [
            'year' => $startDate->format('Y'),
            'month' => $startDate->format('m'),
            'city' => $city,
        ];
    }
}
