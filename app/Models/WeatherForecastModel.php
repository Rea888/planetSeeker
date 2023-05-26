<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherForecastModel extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'temperature',
    ];
}
