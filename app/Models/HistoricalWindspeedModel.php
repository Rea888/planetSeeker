<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalWindspeedModel extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'windspeed_10m',
    ];
}
