<?php

namespace App\Data;

use DateTime;

class DataIdentifier
{
    public function __construct(
        private readonly string   $city,
        private readonly DateTime $dateTime
    )
    {

    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }


}
