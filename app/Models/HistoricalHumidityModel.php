<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalHumidityModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'relativehumidity_2m',
    ];
}
