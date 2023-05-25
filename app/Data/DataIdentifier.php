<?php

namespace App\Data;

use DateTimeImmutable;

class DataIdentifier
{
    public function __construct(private readonly string   $city, private readonly DateTimeImmutable $dateTime)
    {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }
}
