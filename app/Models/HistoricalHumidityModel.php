<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalHumidityModel extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'relativehumidity_2m',
    ];
}
