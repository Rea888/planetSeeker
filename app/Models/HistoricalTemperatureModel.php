<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalTemperatureModel extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'temperature_2m',
    ];
}
