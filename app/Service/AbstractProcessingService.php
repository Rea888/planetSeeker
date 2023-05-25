<?php

namespace App\Service;

use App\Contracts\InitializableProcessingServiceInterface;
use DateTime;
use DateTimeImmutable;

abstract class AbstractProcessingService implements InitializableProcessingServiceInterface
{
    public function getModelBasicData(DateTimeImmutable $startDate, string $city): array
    {
        return [
            'city' => $city,
            'year' => $startDate->format('Y'),
            'month' => $startDate->format('m'),
        ];
    }
}
